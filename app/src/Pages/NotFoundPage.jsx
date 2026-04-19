// src/pages/NotFoundPage.jsx
import { useEffect, useRef } from 'react';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import { ScrollSmoother } from 'gsap/ScrollSmoother';
import { Link } from 'react-router-dom';
import '../Styles/NotFoundPage.scss';
import Header from '../components/Header';
import Footer from '../components/Footer';

gsap.registerPlugin(ScrollTrigger, ScrollSmoother);

export default function NotFoundPage() {
  const smootherRef = useRef(null);
  const contentRef = useRef(null);
  const codeRef = useRef(null);
  const titleRef = useRef(null);
  const messageRef = useRef(null);
  const buttonRef = useRef(null);

  useEffect(() => {
    // 1. Initialize Smoother
    const smoother = ScrollSmoother.create({
      wrapper: '#smooth-wrapper',
      content: '#smooth-content',
      smooth: 1.5,
      effects: true,
      normalizeScroll: true,
      ignoreMobileResize: true,
    });
    smootherRef.current = smoother;

    // 2. ResizeObserver for dynamic content
    const RO = new ResizeObserver(() => {
      ScrollTrigger.refresh();
      smoother.refresh();
    });

    if (contentRef.current) {
      RO.observe(contentRef.current);
    }

    // 3. Set initial hidden states
    gsap.set([codeRef.current, titleRef.current, messageRef.current, buttonRef.current], {
      opacity: 0,
      y: 30,
    });

    // 4. GSAP entrance animations
    const tl = gsap.timeline();
    tl.to(codeRef.current, {
      y: 0,
      opacity: 1,
      duration: 0.6,
      ease: 'power3.out',
    })
      .to(
        titleRef.current,
        {
          y: 0,
          opacity: 1,
          duration: 0.8,
          ease: 'power4.out',
        },
        '-=0.3',
      )
      .to(
        messageRef.current,
        {
          y: 0,
          opacity: 1,
          duration: 0.1,
          ease: 'power2.out',
        },
        '-=0.4',
      )
      .to(
        buttonRef.current,
        {
          y: 0,
          opacity: 1,
          duration: 0.5,
          ease: 'back.out(1.2)',
        },
        '-=0.2',
      );

    return () => {
      RO.disconnect();
      if (smoother) smoother.kill();
      tl.kill();
    };
  }, []);

  return (
    <>
      <header className="fixed-header-container">
        <div className="container-xl">
          <Header appear={false} />
        </div>
      </header>

      <div id="smooth-wrapper">
        <div id="smooth-content" ref={contentRef}>
          <main className="mainContainer">
            <section className="notfound-section">
              <div className="container-md">
                <div className="notfound">
                  <div className="notfound__box">
                    <div className="notfound__content">
                      <div className="notfound__code" ref={codeRef}>
                        404
                      </div>
                      <h1 className="notfound__title" ref={titleRef}>
                        Page Not Found
                      </h1>
                      <p className="notfound__message" ref={messageRef}>
                        The page you are looking for doesn't exist or has been moved.
                      </p>
                      <Link to="/" className="notfound__button" ref={buttonRef}>
                        <span>←</span>
                        Back to Home
                      </Link>
                    </div>
                  </div>
                </div>
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
