// src/components/SignUp.jsx
import { useEffect, useRef, useState } from 'react';
import { Eye, EyeOff } from 'lucide-react';
import '../Styles/SignUp.scss';
import gsap from 'gsap';
import { Link, useNavigate } from 'react-router-dom';
import axiosInstance from '../services/axios';

// Price configuration
const prices = {
  basic: { monthly: 29, yearly: 85 },
  pro: { monthly: 59, yearly: 150 },
  enterprise: { monthly: 99, yearly: 210 },
};

export default function SignUp() {
  const [showPassword, setShowPassword] = useState(false);
  const [showConfirm, setShowConfirm] = useState(false);
  const [isLoading, setIsLoading] = useState(false);
  const [errors, setErrors] = useState({});
  const navigate = useNavigate();

  const [formData, setFormData] = useState({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    plan: 'pro',
    billing: 'monthly',
  });

  // Get current price based on selected plan and billing
  const currentPrice = prices[formData.plan][formData.billing];
  const isYearly = formData.billing === 'yearly';
  const monthlyEquivalent = isYearly ? (currentPrice / 12).toFixed(2) : null;
  const savings = isYearly
    ? Math.round(
        ((prices[formData.plan].monthly * 12 - currentPrice) /
          (prices[formData.plan].monthly * 12)) *
          100,
      )
    : 0;

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
      // Step 1: Create pending user
      const response = await axiosInstance.post('/signup', {
        name: formData.name,
        email: formData.email,
        password: formData.password,
        password_confirmation: formData.password_confirmation,
        plan: formData.plan,
        billing: formData.billing,
      });

      if (response.data.success) {
        // Step 2: Create Stripe checkout session
        const checkoutResponse = await axiosInstance.post('/stripe/create-checkout-session', {
          email: formData.email,
        });

        if (checkoutResponse.data.success) {
          // Store email for later use
          localStorage.setItem('pendingEmail', formData.email);
          // Redirect to Stripe checkout
          window.location.href = checkoutResponse.data.session_url;
        } else {
          setErrors({ general: checkoutResponse.data.message || 'Failed to start checkout' });
        }
      }
    } catch (err) {
      console.error('Signup error:', err);
      setErrors({ general: err.response?.data?.message || 'Signup failed' });
    } finally {
      setIsLoading(false);
    }
  };

  const badgeRef = useRef(null);
  const titleRef = useRef(null);
  const subtitleRef = useRef(null);

  useEffect(() => {
    const token = localStorage.getItem('token');
    if (token) {
      navigate('/system/dashboard');
    }

    const tl = gsap.timeline();
    tl.from(badgeRef.current, { y: -20, opacity: 0, duration: 0.6, ease: 'power3.out' })
      .from(titleRef.current, { y: 40, opacity: 0, duration: 0.8, ease: 'power4.out' }, '-=0.3')
      .from(subtitleRef.current, { y: 20, opacity: 0, duration: 0.1, ease: 'power2.out' }, '-=0.4');
    return () => tl.revert();
  }, [navigate]);

  // Get plan display name
  const getPlanName = (plan) => {
    const names = { basic: 'Basic', pro: 'Pro', enterprise: 'Enterprise' };
    return names[plan];
  };

  return (
    <div className="signup">
      <div className="signup__box">
        <div className="signup__header">
          <span className="signup__badge" ref={badgeRef}>
            Join Us
          </span>
          <h1 ref={titleRef}>Create Your Account</h1>
          <p ref={subtitleRef}>Sign up and start managing your driving school</p>
        </div>

        {errors.general && <div className="signup__error">{errors.general}</div>}

        <form className="signup__form" onSubmit={handleSubmit}>
          <div className="signup__field">
            <label>Name</label>
            <input
              type="text"
              name="name"
              placeholder="Full Name"
              value={formData.name}
              onChange={handleChange}
              required
            />
          </div>

          <div className="signup__field">
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

          {/* Plan Selection with Price Display */}
          <div className="signup__field">
            <label>Select Plan</label>
            <div className="signup__plan-selector">
              {['basic', 'pro', 'enterprise'].map((plan) => (
                <div
                  key={plan}
                  className={`signup__plan-option ${formData.plan === plan ? 'active' : ''}`}
                  onClick={() => setFormData((prev) => ({ ...prev, plan }))}
                >
                  <div className="signup__plan-name">{getPlanName(plan)}</div>
                  <div className="signup__plan-price">
                    ${prices[plan][formData.billing]}
                    <span>/{formData.billing === 'yearly' ? 'year' : 'month'}</span>
                  </div>
                  {formData.plan === plan && <div className="signup__plan-check">✓</div>}
                </div>
              ))}
            </div>
          </div>

          {/* Billing Cycle Toggle */}
          <div className="signup__field">
            <label>Billing Cycle</label>
            <div className="signup__billing-toggle">
              <button
                type="button"
                className={`signup__billing-option ${formData.billing === 'monthly' ? 'active' : ''}`}
                onClick={() => setFormData((prev) => ({ ...prev, billing: 'monthly' }))}
              >
                Monthly
              </button>
              <button
                type="button"
                className={`signup__billing-option ${formData.billing === 'yearly' ? 'active' : ''}`}
                onClick={() => setFormData((prev) => ({ ...prev, billing: 'yearly' }))}
              >
                Yearly
                <span className="signup__save-badge">Save {savings}%</span>
              </button>
            </div>
          </div>

          {/* Price Summary */}
          <div className="signup__price-summary">
            <div className="signup__price-summary-title">
              {getPlanName(formData.plan)} Plan -{' '}
              {formData.billing === 'yearly' ? 'Yearly' : 'Monthly'}
            </div>
            <div className="signup__price-summary-amount">
              ${currentPrice}
              <span>/{formData.billing === 'yearly' ? 'year' : 'month'}</span>
            </div>
            {isYearly && (
              <div className="signup__price-summary-savings">
                Just ${monthlyEquivalent}/month, billed annually
              </div>
            )}
          </div>

          <div className="signup__field">
            <label>Password</label>
            <div className="signup__input">
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

          <div className="signup__field">
            <label>Confirm Password</label>
            <div className="signup__input">
              <input
                type={showConfirm ? 'text' : 'password'}
                name="password_confirmation"
                placeholder="Confirm Password"
                value={formData.password_confirmation}
                onChange={handleChange}
                required
              />
              <button type="button" onClick={() => setShowConfirm(!showConfirm)}>
                {showConfirm ? <EyeOff size={18} /> : <Eye size={18} />}
              </button>
            </div>
          </div>

          <button className="signup__submit" type="submit" disabled={isLoading}>
            {isLoading ? 'Creating account...' : `Sign Up & Pay $${currentPrice}`} <span>›</span>
          </button>

          <p className="signup__footer">
            Already have an account?{' '}
            <Link to="/login" style={{ color: '#8cff2e', textDecoration: 'none' }}>
              Sign In
            </Link>
          </p>
        </form>
      </div>
    </div>
  );
}
