// src/PaymentSuccess.jsx
import { useEffect, useState } from 'react';
import { useSearchParams, useNavigate } from 'react-router-dom';
import axiosInstance from '../services/axios';
import '../Styles/PaymentSuccess.scss';

export default function PaymentSuccess() {
  const [searchParams] = useSearchParams();
  const navigate = useNavigate();
  const [status, setStatus] = useState('processing');
  const [error, setError] = useState('');
  const [countdown, setCountdown] = useState(3);

  useEffect(() => {
    const sessionId = searchParams.get('session_id');
    const email = searchParams.get('email') || localStorage.getItem('pendingEmail');

    const activateAndLogin = async () => {
      try {
        console.log('Activating account with:', { sessionId, email });

        const response = await axiosInstance.post('/auth/activate-and-login', {
          session_id: sessionId,
          email: email,
        });

        console.log('Activation response:', response.data);

        if (response.data.success) {
          // Store token
          localStorage.setItem('token', response.data.data.token);
          localStorage.setItem('user', JSON.stringify(response.data.data.user));

          // Clear pending data
          localStorage.removeItem('pendingEmail');

          setStatus('success');

          // Start countdown to dashboard
          const interval = setInterval(() => {
            setCountdown((prev) => {
              if (prev <= 1) {
                clearInterval(interval);
                navigate('/system/dashboard');
                return 0;
              }
              return prev - 1;
            });
          }, 1000);

          return () => clearInterval(interval);
        } else {
          setError(response.data.message || 'Failed to activate account');
          setStatus('error');
        }
      } catch (err) {
        console.error('Activation error:', err);

        // Check if user was already created but token missing
        if (err.response?.status === 422 && err.response?.data?.message?.includes('already')) {
          // Try to login directly
          try {
            const email = localStorage.getItem('pendingEmail');
            const loginResponse = await axiosInstance.post('/login', {
              email: email,
              password: '', // You might need to handle this differently
            });

            if (loginResponse.data.success) {
              localStorage.setItem('token', loginResponse.data.data.token);
              localStorage.setItem('user', JSON.stringify(loginResponse.data.data.user));
              localStorage.removeItem('pendingEmail');
              setStatus('success');
              return;
            }
          } catch (loginErr) {
            console.error('Login error:', loginErr);
          }
        }

        setError(
          err.response?.data?.message || 'Failed to activate account. Please try logging in.',
        );
        setStatus('error');
      }
    };

    if (sessionId && email) {
      activateAndLogin();
    } else {
      setError('Missing payment information');
      setStatus('error');
    }
  }, [searchParams, navigate]);

  const handleRetry = () => {
    navigate('/signup');
  };

  const handleGoToLogin = () => {
    navigate('/login');
  };

  const handleManualRedirect = () => {
    navigate('/system/dashboard');
  };

  return (
    <div className="payment-success">
      <div className="payment-success__container">
        {status === 'processing' && (
          <div className="payment-success__card processing">
            <div className="payment-success__icon">
              <div className="spinner"></div>
            </div>
            <h2>Processing Your Payment...</h2>
            <p>Please wait while we activate your account.</p>
            <p className="payment-success__note">This may take a few seconds...</p>
          </div>
        )}

        {status === 'success' && (
          <div className="payment-success__card success">
            <div className="payment-success__icon success-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2">
                <polyline points="20 6 9 17 4 12" />
              </svg>
            </div>
            <h2>Payment Successful!</h2>
            <p>Your account has been activated.</p>
            <p className="payment-success__redirect">
              Redirecting to dashboard in {countdown} seconds...
            </p>
            <button
              onClick={handleManualRedirect}
              className="btn btn-primary"
              style={{ marginTop: '20px' }}
            >
              Go to Dashboard Now
            </button>
          </div>
        )}

        {status === 'error' && (
          <div className="payment-success__card error">
            <div className="payment-success__icon error-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2">
                <circle cx="12" cy="12" r="10" />
                <line x1="12" y1="8" x2="12" y2="12" />
                <line x1="12" y1="16" x2="12.01" y2="16" />
              </svg>
            </div>
            <h2>Something Went Wrong</h2>
            <p>{error}</p>
            <div className="payment-success__actions">
              <button onClick={handleRetry} className="btn btn-primary">
                Try Again
              </button>
              <button onClick={handleGoToLogin} className="btn btn-secondary">
                Go to Login
              </button>
            </div>
          </div>
        )}
      </div>
    </div>
  );
}
