import { Routes, Route, BrowserRouter } from 'react-router-dom';
import HomePage from '../Pages/Home';
import BlogPage from '../Pages/Blog';
import BlogPost from '../Pages/BlogPost';

export default function AppRoutes() {
  return (
    <BrowserRouter>
      <Routes>
        <Route path="/" element={<HomePage />} />
        <Route path="/blog" element={<BlogPage />} />
        <Route path="/blog/:id" element={<BlogPost />} />
      </Routes>
    </BrowserRouter>
  );
}
