import { useEffect, useRef, useContext } from 'react';
import { useParams } from 'react-router-dom';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import { ScrollSmoother } from 'gsap/ScrollSmoother';

import '../Styles/BlogPost.scss';
import Header from '../components/Header';
import Footer from '../components/Footer';
import ReadyToStartCard from '../components/ReadyToStartCard';
import { BlogContext } from '../contexts/BlogContext';

gsap.registerPlugin(ScrollTrigger, ScrollSmoother);

export default function BlogPost() {
  const smoother_ref = useRef(null);
  const contentRef = useRef(null);

  const { id } = useParams();
  const { main_blog, blogs } = useContext(BlogContext);

  const blog = [...(main_blog || []), ...(blogs || [])].find((b) => b?.id === parseInt(id));

  // Helper function to safely process content
  const processContent = (content) => {
    if (!content || typeof content !== 'string') return { type: 'text', value: '' };

    // Check for bullet points
    if (content.includes('•') || content.includes('-') || content.includes('*')) {
      const items = content
        .split('\n')
        .filter((item) => item && typeof item === 'string' && item.trim() !== '')
        .map((item) => {
          // Remove bullet point symbols
          let cleanItem = item;
          if (cleanItem.match(/^[•\-*]\s*/)) {
            cleanItem = cleanItem.replace(/^[•\-*]\s*/, '');
          }
          return cleanItem.trim();
        });

      return { type: 'list', value: items };
    }

    return { type: 'text', value: content };
  };

  useEffect(() => {
    if (!smoother_ref.current && document.getElementById('smooth_wrapper')) {
      smoother_ref.current = ScrollSmoother.create({
        wrapper: '#smooth_wrapper',
        content: '#smooth_content',
        smooth: 1.2,
        effects: true,
      });
    }

    const ctx = gsap.context(() => {
      if (document.querySelector('.blog-header')) {
        gsap.from('.blog-header', {
          y: 50,
          opacity: 0,
          duration: 1,
        });
      }

      if (contentRef.current && document.querySelectorAll('.blog-content-section').length) {
        gsap.from('.blog-content-section', {
          y: 40,
          opacity: 0,
          stagger: 0.15,
          duration: 0.8,
          scrollTrigger: {
            trigger: contentRef.current,
            start: 'top 80%',
          },
        });
      }
    });

    return () => {
      ctx.revert();
      ScrollTrigger.getAll().forEach((trigger) => trigger.kill());
    };
  }, []);

  if (!blog || !blog.fullContent) {
    return (
      <div id="smooth_wrapper">
        <header className="container-xl">
          <Header appear={false} />
        </header>
        <div id="smooth_content">
          <div className="blog-post">
            <h1 style={{ textAlign: 'center', padding: '100px 20px' }}>Blog post not found</h1>
          </div>
        </div>
      </div>
    );
  }

  return (
    <div id="smooth_wrapper">
      <header className="container-xl">
        <Header appear={false} />
      </header>

      <div id="smooth_content">
        <div className="blog-post">
          <div className="blog-header">
            <div className="blog-meta">
              <span className="blog-category">{blog.category || 'Uncategorized'}</span>
              <span className="blog-date">{blog.date || 'No date'}</span>
            </div>

            <h1>{blog.title || 'Untitled'}</h1>

            <p>{blog.fullContent.intro || ''}</p>

            <div className="blog-image">
              <img
                src={blog.img || '/default-image.jpg'}
                alt={blog.title || 'Blog image'}
                onError={(e) => {
                  e.target.src = '/default-image.jpg';
                }}
              />
            </div>
          </div>

          <div className="blog-content" ref={contentRef}>
            {blog.fullContent.sections?.map((section, i) => (
              <div className="blog-content-section" key={i}>
                <h2>{section.title}</h2>

                {section.content
                  ?.filter((c) => c && typeof c === 'string' && c.trim() !== '')
                  .map((c, index) => {
                    const processed = processContent(c);

                    if (processed.type === 'list') {
                      return (
                        <ul key={index}>
                          {processed.value.map((item, itemIndex) => (
                            <li key={itemIndex}>{item}</li>
                          ))}
                        </ul>
                      );
                    }

                    return <p key={index}>{processed.value}</p>;
                  })}
              </div>
            ))}
          </div>

          <section className="container-md" style={{ marginTop: '200px', marginBottom: '100px' }}>
            <ReadyToStartCard className="p-5" />
          </section>

          <Footer />
        </div>
      </div>
    </div>
  );
}
