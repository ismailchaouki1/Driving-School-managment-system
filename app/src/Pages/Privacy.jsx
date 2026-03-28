import { useEffect, useRef } from 'react';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import { ScrollSmoother } from 'gsap/ScrollSmoother';
import '../Styles/App.scss';
import '../Styles/Privacy.scss';
import Header from '../components/Header';
import Footer from '../components/Footer';
import ReadyToStartCard from '../components/ReadyToStartCard';

gsap.registerPlugin(ScrollTrigger, ScrollSmoother);

export default function PrivacyPage() {
  const smootherRef = useRef(null);
  const contentRef = useRef(null);

  useEffect(() => {
    // Initialize ScrollSmoother once
    if (!smootherRef.current && document.getElementById('smooth-wrapper')) {
      smootherRef.current = ScrollSmoother.create({
        wrapper: '#smooth-wrapper',
        content: '#smooth-content',
        smooth: 1.2,
        effects: true,
      });
    }

    const ctx = gsap.context(() => {
      // Header animation
      gsap.from('.privacy-page h1', {
        y: 50,
        opacity: 0,
        duration: 1,
      });

      gsap.from('.privacy-page h4', {
        y: 30,
        opacity: 0,
        duration: 1,
        delay: 0.2,
      });

      // Paragraph animation (scroll-based)
      if (contentRef.current) {
        gsap.from('.privacy-page p', {
          y: 40,
          opacity: 0,
          duration: 0.8,
          stagger: 0.1,
          scrollTrigger: {
            trigger: contentRef.current,
            start: 'top 80%',
          },
        });
      }

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
      ScrollTrigger.getAll().forEach((trigger) => trigger.kill());
    };
  }, []);

  return (
    <>
      {/* Header stays OUTSIDE smooth-wrapper to remain fixed */}
      <header className="fixed-header-container">
        <div className="container-xl">
          <Header appear={false} />
        </div>
      </header>

      <div id="smooth-wrapper">
        <div id="smooth-content">
          <main className="mainContainer" ref={smootherRef}>
            <section className="privacy-page">
              <h1>Privacy Policy</h1>
              <h4>Last updated: April 2025</h4>

              <p>
                Your privacy is important to us. This Privacy Policy explains how Clario collects,
                uses, and protects your personal information when you use our website or services.
                By accessing or using Clario, you agree to the practices described in this policy.
                <br />
                <br />
                We may collect personal information that you provide directly to us, such as your
                name, email address, and any other details you submit when using our services. We
                may also collect non-personal information automatically, such as browser type,
                device information, and usage data to help us improve our platform.
                <br />
                <br />
                The information we collect is used to provide, maintain, and improve our services,
                communicate with you, process transactions, and ensure the security and
                functionality of our platform. We do not sell your personal data to third parties.
                <br />
                <br />
                We may use cookies and similar tracking technologies to enhance your experience,
                analyze usage patterns, and personalize content. You can control or disable cookies
                through your browser settings, though some features of the website may not function
                properly without them.
                <br />
                <br />
                We implement reasonable security measures to protect your personal information from
                unauthorized access, alteration, disclosure, or destruction. However, no method of
                transmission over the internet or electronic storage is completely secure, and we
                cannot guarantee absolute security.
                <br />
                <br />
                Our services may include links to third-party websites or services. We are not
                responsible for the privacy practices or content of those external sites. We
                encourage you to review their privacy policies before providing any personal
                information.
                <br />
                <br />
                We may update this Privacy Policy from time to time to reflect changes in our
                practices, legal requirements, or services. If we make significant changes, we will
                notify you through our website or other appropriate means. Continued use of our
                services after such updates means you accept the revised policy.
                <br />
                <br />
                If you have any questions about this Privacy Policy or how your data is handled,
                please contact us at [Insert Contact Email]. We’re here to help.
              </p>
            </section>

            <section
              className="ready-section"
              style={{ marginBottom: '150px', marginTop: '500px' }}
            >
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
