import '../Styles/HeroSection.scss';
import '../Styles/App.scss';
import { gsap } from 'gsap';
import { useRef, useEffect } from 'react';
import { ScrollTrigger } from 'gsap/all';
export default function HeroSection() {
  const badge = useRef(null);
  const title = useRef(null);
  const subtitle = useRef(null);
  const btnStart = useRef(null);
  const img = useRef(null);
  useEffect(() => {
    gsap.registerPlugin(ScrollTrigger);
    gsap.fromTo(
      img.current,
      { scale: 0.8, y: 100, opacity: 0.7 }, // start smaller & lower
      {
        scale: 1, // final normal size
        y: 0, // move to normal position
        opacity: 1, // fully visible
        scrollTrigger: {
          trigger: img.current,
          start: 'top 80%', // when image top is 80% from top of viewport
          end: 'top 20%', // until image top is near top of viewport
          scrub: true, // smooth tie to scroll
        },
      },
    );
    let tl = gsap.timeline({
      defaults: { duration: 1.5, ease: 'power1.inout' },
    });
    tl.from(badge.current, { y: 40, opacity: 0 }, 0)
      .from(title.current, { y: 40, opacity: 0 }, 0)
      .from(subtitle.current, { y: 40, opacity: 0 }, 0)
      .from(btnStart.current, { y: 40, opacity: 0 }, 0);
    return () => tl.revert();
  }, []);
  return (
    <div className="container-md heroSection">
      <div className="hero-badge" ref={badge}>
        {' '}
        All-in-One Management Platform
      </div>
      <h1 className="hero-title" ref={title}>
        Take control of your Business — with Clario
      </h1>
      <p className="hero-subtitle" ref={subtitle}>
        Organize your driving school’s operations from students to invoices through one powerful and
        unified interface.
      </p>
      <button className="btn hero-button rounded-pill" ref={btnStart}>
        Get Started Free Trial
        <span className="arrow-box">
          {/* FIRST ARROW */}
          <svg
            className="arrow first"
            width="18"
            height="18"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            strokeWidth="2"
          >
            <path d="M7 17L17 7M17 7H8M17 7V16" />
          </svg>

          {/* SECOND ARROW */}
          <svg
            className="arrow second"
            width="18"
            height="18"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            strokeWidth="2"
          >
            <path d="M7 17L17 7M17 7H8M17 7V16" />
          </svg>
        </span>
      </button>
      <div class="hero-image" ref={img}>
        <div className="image"></div>
      </div>
    </div>
  );
}
