import { useEffect, useRef } from 'react';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import { ScrollSmoother } from 'gsap/ScrollSmoother';
import '../Styles/Terms.scss';
import Header from '../components/Header';
import Footer from '../components/Footer';
import ReadyToStartCard from '../components/ReadyToStartCard';

gsap.registerPlugin(ScrollTrigger, ScrollSmoother);

export default function TermsPage() {
  const smootherRef = useRef(null);

  useEffect(() => {
    // Initialize ScrollSmoother after component mounts
    const initSmoother = () => {
      if (!smootherRef.current && document.getElementById('smooth-wrapper')) {
        smootherRef.current = ScrollSmoother.create({
          wrapper: '#smooth-wrapper',
          content: '#smooth-content',
          smooth: 1.2,
          effects: true,
          normalizeScroll: true, // Helps with scroll behavior
          ignoreMobileResize: true,
        });
      }
    };

    // Small delay to ensure DOM is ready
    setTimeout(initSmoother, 100);

    const ctx = gsap.context(() => {
      // Header animation
      gsap.from('.terms-page h1', {
        y: 50,
        opacity: 0,
        duration: 1,
      });

      gsap.from('.terms-page h4', {
        y: 30,
        opacity: 0,
        duration: 1,
        delay: 0.2,
      });

      // Paragraph animation (scroll-based)
      gsap.from('.terms-page p', {
        y: 40,
        opacity: 0,
        duration: 0.8,
        stagger: 0.1,
        scrollTrigger: {
          trigger: '.terms-page',
          start: 'top 80%',
        },
      });

      // Optional: ready section animation
      gsap.from('.ready-section', {
        y: 60,
        opacity: 0,
        duration: 1,
        scrollTrigger: {
          trigger: '.ready-section',
          start: 'top 85%',
        },
      });
    });

    return () => {
      ctx.revert();
      if (smootherRef.current) {
        smootherRef.current.kill();
        smootherRef.current = null;
      }
      ScrollTrigger.getAll().forEach((trigger) => trigger.kill());
    };
  }, []);

  return (
    <>
      {/* Header stays OUTSIDE smooth-wrapper to remain fixed */}
      <div className="fixed-header-container">
        <div className="container-xl">
          <Header appear={false} />
        </div>
      </div>

      <div id="smooth-wrapper">
        <div id="smooth-content">
          <main className="mainContainer">
            <section className="terms-page">
              <h1>Terms &amp; Conditions</h1>
              <h4>Last updated: April 2025</h4>

              <p>
                By accessing and using Clario, you agree to these terms. Please read them carefully
                before using our website or services. You must be at least 18 years old to use
                Clario. By using our services, you confirm that you meet this requirement. If you
                are accessing Clario on behalf of an organization, you confirm that you have the
                authority to bind the organization to these terms.
                <br />
                <br />
                All content on our website, including text, graphics, logos, images, and software,
                is the property of Clario or its licensors. This content is protected by
                intellectual property laws. You may not reproduce, distribute, modify, or create
                derivative works based on our content without prior written consent.
                <br />
                <br />
                We work hard to keep Clario running smoothly and securely, but we cannot guarantee
                that our services will always be available, uninterrupted, or error-free. We are not
                liable for any interruptions, delays, or losses resulting from using our platform.
                You understand and agree that you use our services at your own risk.
                <br />
                <br />
                When using Clario, you agree to use our services responsibly. You must not misuse
                our platform, attempt to gain unauthorized access, or engage in any activity that
                could harm our website, users, or reputation. We reserve the right to suspend or
                terminate your account if you violate these terms or engage in harmful behavior.
                <br />
                <br />
                Our services may include links to third-party websites or services. These external
                links are provided for convenience, but we do not control or endorse their content.
                We are not responsible for the privacy practices, terms, or content of any
                third-party sites you visit.
                <br />
                <br />
                Payments and subscriptions for Clario services are billed as described on our
                pricing page. By purchasing a subscription, you authorize us to charge your selected
                payment method. You may cancel your subscription at any time, but please note that
                fees are non-refundable unless required by law.
                <br />
                <br />
                Your privacy is important to us. Please review our Privacy Policy to understand how
                we collect, use, and protect your personal data when you use Clario.
                <br />
                <br />
                We may update these Terms of Service from time to time to reflect changes in our
                services, legal requirements, or policies. If we make significant changes, we will
                notify you through our website or by email. Continued use of our services after
                changes means you accept the updated terms. We encourage you to review these terms
                periodically.
                <br />
                <br />
                If you have any questions about these terms or our services, feel free to contact us
                at [Insert Contact Email]. We’re here to help.
              </p>
            </section>

            <section className="ready-section">
              <div className="container-md">
                <ReadyToStartCard />
              </div>
            </section>

            <footer className="footer-section">
              <div className="container-fluid">
                <Footer />
              </div>
            </footer>
          </main>
        </div>
      </div>
    </>
  );
}
