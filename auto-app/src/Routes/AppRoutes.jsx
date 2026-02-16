import { Routes, Route, Outlet } from "react-router";
import HomePage from "../Pages/Home";
export default function AppRoutes() {
  return (
    <div>
      <Routes>
        <Route path="/" element={<Outlet />}>
          <Route index element={<HomePage />} />
        </Route>
      </Routes>
    </div>
  );
}
