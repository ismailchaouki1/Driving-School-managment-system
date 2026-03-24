import '../Styles/App.scss';
import '../Styles/BlogSection.scss';
import BlogCard from './blogCard';
import { useContext } from 'react';
import { BlogContext } from '../contexts/BlogContext';
export default function BlogSection() {
  const myContext = useContext(BlogContext);
  const mainBlog = myContext.main_blog;
  const BlogList = myContext.blogs;
  return (
    <div className="blog-section">
      <div className="blog-titles">
        <h1>Explore the blog</h1>
        <button className="view-posts-btn rounded-pill">
          View all posts
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
      </div>
      <div className="blogs">
        <div className="first-blog">
          <div className="blog-image">
            <div className="blog-img-div"></div>
          </div>
          {mainBlog.map((blog) => (
            <div className="blog-content" key={blog.id}>
              <div className="blog-badge">
                <span>{blog.category}</span>
                <h1>{blog.title}</h1>
              </div>
              <span className="blog-desc">{blog.description}</span>
              <button className="readMore  rounded-pill">
                Read more
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
            </div>
          ))}
        </div>
        <div className="other-blogs" style={{ marginTop: '20px' }}>
          {BlogList.map((b) => (
            <BlogCard
              className="blog-card"
              key={b.id}
              badge={b.category}
              title={b.title}
              img={b.img}
            />
          ))}
        </div>
      </div>
    </div>
  );
}
