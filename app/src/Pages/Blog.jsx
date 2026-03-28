import { useEffect, useRef } from 'react';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import { ScrollSmoother } from 'gsap/ScrollSmoother';
import '../Styles/App.scss';
import '../Styles/Home.scss';
import Header from '../components/Header';
import BlogSection from '../components/BlogSection';
import Footer from '../components/Footer';
import ReadyToStartCard from '../components/ReadyToStartCard';

gsap.registerPlugin(ScrollTrigger, ScrollSmoother);

export default function BlogPage() {
  const smootherRef = useRef(null);

  useEffect(() => {
    // Initialize ScrollSmoother once
    const smoother = ScrollSmoother.create({
      wrapper: '#smooth-wrapper',
      content: '#smooth-content',
      smooth: 1.5,
      effects: true,
      normalizeScroll: true,
    });

    smootherRef.current = smoother;

    if (window.location.hash) {
      const timer = setTimeout(() => {
        smoother.scrollTo(window.location.hash, true, 'top 80px');
      }, 500);
      return () => clearTimeout(timer);
    }

    return () => {
      if (smoother) smoother.kill();
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
          <main className="mainContainer">
            {/* We use padding-top here to push the content down 
               so it doesn't hide behind your fixed header 
            */}
            <section className="blogs-section">
              <div className="container-md">
                <BlogSection blogpage={false} />
              </div>
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
