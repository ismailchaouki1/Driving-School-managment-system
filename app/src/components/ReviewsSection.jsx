import '../Styles/App.scss';
import '../Styles/ReviewsSection.scss';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faQuoteLeft } from '@fortawesome/free-solid-svg-icons';
import gsap from 'gsap';
import { useEffect, useRef } from 'react';
export default function ReviewsSection() {
  const container = useRef(null);
  const title = useRef(null);
  const subtitle = useRef(null);
  useEffect(() => {
    const ctx = gsap.context(() => {
      const tl = gsap.timeline({
        scrollTrigger: {
          trigger: [title.current, subtitle.current],
          start: 'top 80%', // when section enters viewport
          end: 'bottom 20%',
          toggleActions: 'play none none none', // play once
          scrub: false, // set to true if you want scroll-controlled animation
          // markers: true,     // enable for debugging
        },
        defaults: {
          duration: 1.2,
          ease: 'power3.out', // smoother easing
        },
      });

      tl.from(title.current, {
        x: 200,
        opacity: 0,
        duration: 0.8,
      }).from(
        subtitle.current,
        {
          x: -200,
          opacity: 0,
          duration: 1,
        },
        '-=0.4',
      );
    });

    return () => ctx.revert();
  }, []);
  const reviews = [
    {
      text: 'Big effort - high quality. Best driving school platform out there.',
      name: 'Yassine M.',
      role: 'Driving Instructor',
    },
    {
      text: 'This system made managing lessons feel simple. Everything’s in one place.',
      name: 'Salma T.',
      role: 'Auto-école Owner',
    },
    {
      text: 'I finally track my progress and actually stay consistent.',
      name: 'Omar K.',
      role: 'Student Driver',
    },
    {
      text: 'No more scheduling chaos. Just clean organization.',
      name: 'Karim L.',
      role: 'School Manager',
    },
    {
      text: 'It feels like this app understands how driving schools work.',
      name: 'Nadia R.',
      role: 'Administrator',
    },
  ];
  return (
    <div className="review" ref={container}>
      <div className="review-titles">
        <div className="review-title" ref={title}>
          <h1>Built for driving schools and future drivers</h1>
        </div>
        <div className="review-subtitle" ref={subtitle}>
          <p>
            Learners and driving schools rely on our platform to manage lessons, track progress, and
            simplify scheduling — all in one smart dashboard.
          </p>
        </div>
      </div>
      <section className="reviews">
        <div className="reviews-wrapper">
          <div className="reviews-track">
            {[...reviews, ...reviews].map((review, i) => (
              <div className="review-card" key={i}>
                <div className="review-content">
                  <FontAwesomeIcon className="quote-icon" icon={faQuoteLeft} />
                  {'  '}
                  <p className="review-text">{review.text}</p>
                </div>

                <div className="review-user">
                  <img src={`https://i.pravatar.cc/50?img=${i + 10}`} alt="" />
                  <div>
                    <h4>{review.name}</h4>
                    <span>{review.role}</span>
                  </div>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>
      <section className="reviews2">
        <div className="reviews-wrapper2">
          <div className="reviews-track2">
            {[...reviews, ...reviews].map((review, i) => (
              <div className="review-card2" key={i}>
                <div className="review-content2">
                  <FontAwesomeIcon className="quote-icon2" icon={faQuoteLeft} />
                  {'  '}
                  <p className="review-text2">{review.text}</p>
                </div>

                <div className="review-user2">
                  <img src={`https://i.pravatar.cc/50?img=${i + 10}`} alt="" />
                  <div>
                    <h4>{review.name}</h4>
                    <span>{review.role}</span>
                  </div>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>
    </div>
  );
}
