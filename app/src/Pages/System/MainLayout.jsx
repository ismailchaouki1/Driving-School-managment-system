// Pages/System/MainLayout.jsx
import React, { useState } from 'react';
import { Outlet, Link, useLocation, useNavigate } from 'react-router-dom';
import {
  LayoutDashboard,
  Users,
  Calendar,
  Car,
  CreditCard,
  Settings,
  LogOut,
  Menu,
  X,
  Bell,
  Search,
  User,
  ChevronDown,
  ChartArea,
} from 'lucide-react';
import '../../Styles/MainLayout.scss';

const MainLayout = () => {
  const [sidebarOpen, setSidebarOpen] = useState(true);
  const [userMenuOpen, setUserMenuOpen] = useState(false);
  const location = useLocation();
  const navigate = useNavigate();

  const menuItems = [
    { path: '/system/dashboard', icon: <LayoutDashboard size={20} />, label: 'Dashboard' },
    { path: '/system/students', icon: <Users size={20} />, label: 'Students' },
    { path: '/system/sessions', icon: <Calendar size={20} />, label: 'Sessions' },
    { path: '/system/vehicles', icon: <Car size={20} />, label: 'Vehicles' },
    { path: '/system/payments', icon: <CreditCard size={20} />, label: 'Payments' },
    { path: '/system/statistics', icon: <ChartArea size={20} />, label: 'Statistics' },
    { path: '/system/settings', icon: <Settings size={20} />, label: 'Settings' },
  ];

  const handleLogout = () => {
    localStorage.removeItem('token');
    navigate('/login');
  };

  return (
    <div className="main-layout">
      {/* Sidebar */}
      <aside className={`sidebar ${sidebarOpen ? 'open' : 'closed'}`}>
        <div className="sidebar-header">
          <div className="logo">
            <div className="logo-icon">
              <svg
                onClick={() => setSidebarOpen(!sidebarOpen)}
                xmlns="http://www.w3.org/2000/svg"
                width="41"
                height="23"
                fill="none"
                overflow="visible"
              >
                {sidebarOpen ? <X size={18} /> : <Menu size={18} />}
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
              </svg>{' '}
            </div>
            {sidebarOpen && <span className="logo-text">Clario</span>}
          </div>
        </div>

        <nav className="sidebar-nav">
          {menuItems.map((item) => (
            <Link
              key={item.path}
              to={item.path}
              className={`sideBarOpen ${location.pathname === item.path ? 'active' : ''}`}
            >
              {item.icon}
              {sidebarOpen && <span>{item.label}</span>}
            </Link>
          ))}
        </nav>

        <div className="sidebar-footer">
          <div className="user-info-sidebar">
            <div className="user-avatar-sidebar">
              <User size={20} />
            </div>
            {sidebarOpen && (
              <div className="user-details">
                <span className="user-name">Alex Johnson</span>
                <span className="user-email">alex@autoecole.com</span>
              </div>
            )}
          </div>
          <button onClick={handleLogout} className="logout-btn">
            <LogOut size={20} />
            {sidebarOpen && <span>Logout</span>}
          </button>
        </div>
      </aside>

      {/* Main Content */}
      <div className="main-content">
        <header className="main-header">
          <div className="header-left">
            <h1>
              {menuItems.find((item) => item.path === location.pathname)?.label || 'Dashboard'}
            </h1>
          </div>
          <div className="header-right">
            <div className="search-bar">
              <Search size={18} />
              <input type="text" placeholder="Search..." />
            </div>
            <button className="notification-btn">
              <Bell size={20} />
              <span className="notification-badge"></span>
            </button>
            <div className="user-menu" onClick={() => setUserMenuOpen(!userMenuOpen)}>
              <div className="user-avatar">
                <User size={20} />
              </div>
              <div className="user-info">
                <span className="user-name">Alex Johnson</span>
                <span className="user-role">Administrator</span>
              </div>
              <ChevronDown size={16} />
            </div>
            {userMenuOpen && (
              <div className="user-dropdown">
                <button>Profile</button>
                <button>Settings</button>
                <button onClick={handleLogout}>Logout</button>
              </div>
            )}
          </div>
        </header>

        <main className="content-area">
          <Outlet />
        </main>
      </div>
    </div>
  );
};

export default MainLayout;
