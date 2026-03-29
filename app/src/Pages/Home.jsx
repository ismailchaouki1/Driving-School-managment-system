import { useEffect, useRef } from 'react';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import { ScrollSmoother } from 'gsap/ScrollSmoother';

import '../Styles/Home.scss';
import Header from '../components/Header';
import HeroSection from '../components/HeroSection';
import HowItWorks from '../components/HowitWorks';
import Why from '../components/WhySection';
import ReviewsSection from '../components/ReviewsSection';
import Features from '../components/Features';
import ChatwayWidget from '../chatway Component/chatbot/ChatwayWidget';
import HearFromUser from '../components/HearFromUser';
import PricingSection from '../components/PricingSection';
import FAQ from '../components/FAQ';
import BlogSection from '../components/BlogSection';
import ReadyToStartCard from '../components/ReadyToStartCard';
import Footer from '../components/Footer';

gsap.registerPlugin(ScrollTrigger, ScrollSmoother);

export default function HomePage() {
  const smootherRef = useRef(null);
  useEffect(() => {
    // 1. Initialize Smoother and store in Ref to access it elsewhere
    smootherRef.current = ScrollSmoother.create({
      wrapper: '#smooth-wrapper',
      content: '#smooth-content',
      smooth: 1.5,
      effects: true,
      normalizeScroll: true, // Prevents address bar jitter on mobile
    });

    // 2. The Logic for Navigation
    const handleNavClick = (e) => {
      const link = e.target.closest('.nav-link');
      if (!link) return;

      const href = link.getAttribute('href');

      if (href && href.startsWith('#')) {
        e.preventDefault();

        // Ensure the smoother exists before calling scrollTo
        if (smootherRef.current) {
          smootherRef.current.scrollTo(href, true, 'top 80px');
        }

        // Mobile Menu Cleanup
        const menu = document.querySelector('.navbar-collapse');
        if (menu?.classList.contains('show')) {
          menu.classList.remove('show');
          document.querySelector('.navbar-toggler')?.classList.remove('open');
        }
      }
    };

    // 3. Refresh ScrollTrigger after components mount to fix height "lag"
    ScrollTrigger.refresh();

    document.addEventListener('click', handleNavClick);

    return () => {
      document.removeEventListener('click', handleNavClick);
      if (smootherRef.current) smootherRef.current.kill();
    };
  }, []);

  return (
    <div id="smooth-wrapper">
      <header className="container-xl">
        <Header />
      </header>
      <div id="smooth-content">
        <div className="mainContainer">
          <ChatwayWidget id="chatway" />

          <section className="container-md">
            <HeroSection />
          </section>

          <section className="container-md" id="how-it-works">
            <HowItWorks />
          </section>
          <section className="container-md">
            <Why />
          </section>
          <section className="container-md">
            <ReviewsSection />
          </section>
          <section className="container-md" id="features">
            <Features />
          </section>
          <section className="container-md">
            <HearFromUser />
          </section>
          <section className="container-md" id="pricing">
            <PricingSection />
          </section>
          <section className="container-md">
            <FAQ />
          </section>
          <section className="container-md" id="blog">
            <BlogSection />
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
