import '../Styles/App.scss';
import '../Styles/Why.scss';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faCircleCheck, faCircleXmark } from '@fortawesome/free-regular-svg-icons';
import { useEffect, useRef } from 'react';
import { gsap } from 'gsap';
export default function Why() {
  const badge = useRef(null);
  const title = useRef(null);
  const clario = useRef(null);
  const container = useRef(null);
  useEffect(() => {
    const ctx = gsap.context(() => {
      const tl = gsap.timeline({
        scrollTrigger: {
          trigger: container.current,
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

      tl.from(badge.current, {
        y: 40,
        opacity: 0,
        duration: 0.8,
      })
        .from(
          title.current,
          {
            y: 50,
            opacity: 0,
            duration: 0.8,
          },
          '-=0.4',
        )
        .from(
          clario.current,
          {
            x: 80,
            opacity: 0,
            duration: 1.3,
          },
          '-=0.6',
        );
    });

    return () => ctx.revert();
  }, []);
  return (
    <div className="container-md why" ref={container}>
      <div className="title-badge" ref={badge}>
        • Why Clario ?
      </div>
      <h1 className="title-why" ref={title}>
        There’s a smarter way to manage your business
      </h1>
      <div className="comparison">
        <div className="other-tools">
          <h4>Other Tools</h4>
          <span>
            <FontAwesomeIcon icon={faCircleXmark} color="red" /> Manual student tracking with
            spreadsheets
          </span>
          <span>
            <FontAwesomeIcon icon={faCircleXmark} color="red" /> Lesson scheduling conflicts
          </span>
          <span>
            <FontAwesomeIcon icon={faCircleXmark} color="red" /> Paper-based payments & invoices
          </span>
          <span>
            <FontAwesomeIcon icon={faCircleXmark} color="red" /> No real-time progress tracking
          </span>
          <span>
            <FontAwesomeIcon icon={faCircleXmark} color="red" /> Limited communication with
            instructors
          </span>
          <span>
            <FontAwesomeIcon icon={faCircleXmark} color="red" /> No automated reminders
          </span>
        </div>
        <div className="clario" ref={clario}>
          <h4>
            <svg
              className="logo-compare"
              xmlns="http://www.w3.org/2000/svg"
              width="48"
              height="30"
              fill="none"
              overflow="visible"
            >
              <g>
                <path
                  d="M 21.821 0.929 C 22.354 0.38 23.092 0.068 23.865 0.065 L 33.762 0.065 C 40.198 0.065 43.42 8.011 38.869 12.659 L 28.958 22.783 C 28.503 23.247 27.725 22.918 27.725 22.26 L 27.725 13.345 L 28.87 12.174 C 29.78 11.245 29.136 9.656 27.848 9.656 L 13.276 9.656 L 21.821 0.929 Z"
                  fill="rgb(255, 255, 255)"
                ></path>
                <path
                  d="M 19.179 22.071 C 18.646 22.62 17.908 22.932 17.135 22.935 L 7.238 22.935 C 0.802 22.935 -2.42 14.988 2.131 10.341 L 12.042 0.217 C 12.497 -0.247 13.276 0.082 13.276 0.739 L 13.276 9.655 L 12.13 10.825 C 11.22 11.755 11.864 13.344 13.152 13.344 L 27.724 13.344 L 19.178 22.071 Z"
                  fill="rgb(255, 255, 255)"
                ></path>
              </g>
            </svg>
            {''}
            Clario
          </h4>

          <span>
            <FontAwesomeIcon icon={faCircleCheck} color="#8cff2e" /> Centralized student &
            instructor management
          </span>
          <span>
            <FontAwesomeIcon icon={faCircleCheck} color="#8cff2e" /> Automated lesson scheduling
          </span>
          <span>
            <FontAwesomeIcon icon={faCircleCheck} color="#8cff2e" /> Real-time payment & invoice
            system
          </span>
          <span>
            <FontAwesomeIcon icon={faCircleCheck} color="#8cff2e" /> Smart performance tracking
          </span>
          <span>
            <FontAwesomeIcon icon={faCircleCheck} color="#8cff2e" /> Automated reminders for lessons
            & exams
          </span>
          <span>
            <FontAwesomeIcon icon={faCircleCheck} color="#8cff2e" /> Save hours of administrative
            work
          </span>
        </div>
      </div>
    </div>
  );
}
