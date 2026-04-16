// src/components/Login.jsx
import { useEffect, useRef, useState } from 'react';
import { Eye, EyeOff } from 'lucide-react';
import '../Styles/Login.scss';
import gsap from 'gsap';
import { Link, useNavigate } from 'react-router-dom';
import axiosInstance from '../services/axios';

export default function Login() {
  const [showPassword, setShowPassword] = useState(false);
  const [isLoading, setIsLoading] = useState(false);
  const [errors, setErrors] = useState({});
  const navigate = useNavigate();
  const [rememberMe, setRememberMe] = useState(false);

  const [formData, setFormData] = useState({
    email: '',
    password: '',
  });

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData((prev) => ({
      ...prev,
      [name]: value,
    }));
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setIsLoading(true);
    setErrors({});

    try {
      const response = await axiosInstance.post('/login', {
        email: formData.email,
        password: formData.password,
      });

      if (response.data.success) {
        localStorage.setItem('token', response.data.data.token);
        localStorage.setItem('user', JSON.stringify(response.data.data.user));
        navigate('/system/dashboard');
      }
    } catch (err) {
      console.error('Login error:', err);
      if (err.response?.status === 403) {
        setErrors({
          general:
            err.response?.data?.message || 'Please complete payment to activate your account.',
        });
      } else if (err.response?.status === 422) {
        setErrors({ general: 'Invalid email or password' });
      } else {
        setErrors({ general: 'Login failed. Please try again.' });
      }
    } finally {
      setIsLoading(false);
    }
  };

  const badgeRef = useRef(null);
  const titleRef = useRef(null);
  const subtitleRef = useRef(null);

  useEffect(() => {
    // Check if user is already logged in
    const token = localStorage.getItem('token');
    if (token) {
      navigate('/system/dashboard');
    }

    const tl = gsap.timeline();
    tl.from(badgeRef.current, {
      y: -20,
      opacity: 0,
      duration: 0.6,
      ease: 'power3.out',
    })
      .from(
        titleRef.current,
        {
          y: 40,
          opacity: 0,
          duration: 0.8,
          ease: 'power4.out',
        },
        '-=0.3',
      )
      .from(
        subtitleRef.current,
        {
          y: 20,
          opacity: 0,
          duration: 0.1,
          ease: 'power2.out',
        },
        '-=0.4',
      );
    return () => tl.revert();
  }, [navigate]);

  return (
    <div className="login">
      <div className="login__box">
        <div className="login__header">
          <span className="login__badge" ref={badgeRef}>
            Welcome Back
          </span>
          <h1 ref={titleRef}>Sign In</h1>
          <p ref={subtitleRef}>Access your driving school dashboard</p>
        </div>

        {errors.general && <div className="login__error">{errors.general}</div>}

        <form className="login__form" onSubmit={handleSubmit}>
          <div className="login__field">
            <label>Email</label>
            <input
              type="email"
              name="email"
              placeholder="Your Email"
              value={formData.email}
              onChange={handleChange}
              required
            />
          </div>

          <div className="login__field">
            <label>Password</label>
            <div className="login__input">
              <input
                type={showPassword ? 'text' : 'password'}
                name="password"
                placeholder="Password"
                value={formData.password}
                onChange={handleChange}
                required
              />
              <button type="button" onClick={() => setShowPassword(!showPassword)}>
                {showPassword ? <EyeOff size={18} /> : <Eye size={18} />}
              </button>
            </div>
          </div>

          <div className="login__options">
            <label className="login__remember">
              <input
                type="checkbox"
                checked={rememberMe}
                onChange={(e) => setRememberMe(e.target.checked)}
              />
              <span>Remember me</span>
            </label>
            <Link to="/forgot-password" className="login__forgot">
              Forgot Password?
            </Link>
          </div>

          <button className="login__submit" type="submit" disabled={isLoading}>
            {isLoading ? 'Signing in...' : 'Sign In'} <span>›</span>
          </button>

          <p className="login__footer">
            Don't have an account?{' '}
            <Link to="/signup" style={{ textDecoration: 'none', color: '#8cff2e' }}>
              Sign Up
            </Link>
          </p>
        </form>
      </div>
    </div>
  );
}
