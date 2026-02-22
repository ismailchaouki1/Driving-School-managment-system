import { Routes, Route, Outlet } from 'react-router';
import HomePage from '../Pages/Home';
export default function AppRoutes() {
  return (
    <div>
      <Routes>
        <Route path="/" element={<HomePage />} />
      </Routes>
    </div>
  );
}
