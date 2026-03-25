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
  useEffect(() => {
    if (!smootherRef.current) {
      smootherRef.current = ScrollSmoother.create({
        wrapper: '#smooth-wrapper',
        content: '#smooth-content',
        smooth: 1.5,
        effects: true,
        normalizeScroll: true,
      });
    }
    const smoother = ScrollSmoother.create({});
    // If the URL has a hash (like #features), scroll to it after load
    if (window.location.hash) {
      const timer = setTimeout(() => {
        smoother.scrollTo(window.location.hash, true, 'top 80px');
      }, 500); // Give components time to render
      return () => clearTimeout(timer);
    }
  }, []);

  return (
    <div id="smooth-wrapper">
      <header className="container-xl">
        <Header appear={false} />
      </header>
      <div id="smooth-content">
        <div className="mainContainer" ref={smootherRef}>
          <section className="container-md blogs" style={{ marginBottom: '500px' }}>
            <BlogSection blogpage={false} />
          </section>
          <section className="container-md">
            <ReadyToStartCard />
          </section>
          <section className="container-fluid">
            <Footer />
          </section>
        </div>
      </div>
    </div>
  );
}
