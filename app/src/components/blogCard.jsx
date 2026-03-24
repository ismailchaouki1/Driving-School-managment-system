import '../Styles/App.scss';
import '../Styles/blogCard.scss';
export default function BlogCard({ badge, title, img }) {
  return (
    <div className="card-blog">
      <div className="card-blog-image">
        <div className="card-blog-img-div" style={{ backgroundImage: 'url(  ' + img + ' )' }}></div>
      </div>
      <div className="card-blog-content">
        <span className="blog-card-badge">{badge}</span>
        <h1 className="blog-card-title">{title}</h1>
        <button className="card-readMore  rounded-pill">
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
    </div>
  );
}
