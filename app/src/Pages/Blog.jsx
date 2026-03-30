import { useEffect, useRef } from 'react';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import { ScrollSmoother } from 'gsap/ScrollSmoother';
import '../Styles/Home.scss';
import Header from '../components/Header';
import BlogSection from '../components/BlogSection';
import Footer from '../components/Footer';
import ReadyToStartCard from '../components/ReadyToStartCard';

gsap.registerPlugin(ScrollTrigger, ScrollSmoother);

export default function BlogPage() {
  const smootherRef = useRef(null);
  const contentRef = useRef(null);

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

    // 2. THE FIX: ResizeObserver
    // This detects if your BlogSection or Card changes height after loading
    const RO = new ResizeObserver(() => {
      ScrollTrigger.refresh();
      smoother.refresh();
    });

    if (contentRef.current) {
      RO.observe(contentRef.current);
    }

    // 3. Handle Hash Links
    if (window.location.hash) {
      const timer = setTimeout(() => {
        smoother.scrollTo(window.location.hash, true, 'top 80px');
      }, 500);
      return () => clearTimeout(timer);
    }

    return () => {
      RO.disconnect();
      if (smoother) smoother.kill();
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
            <section className="blogs-section" style={{ marginBottom: '400px' }}>
              <div className="container-md">
                <BlogSection blogpage={false} />
              </div>
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
