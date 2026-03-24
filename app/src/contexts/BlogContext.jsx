import { createContext } from 'react';
import img from '../assets/images/blog1.png';
import img1 from '../assets/images/blog2.jpg';
import img2 from '../assets/images/blog4.jpg';
import img3 from '../assets/images/blog5.jpg';

export const BlogContext = createContext({
  main_blog: [
    {
      id: 1,
      title: 'What Is a Driving School Management System?',
      category: 'System',
      date: 'March 10, 2026',
      img: img,
      description:
        'Learn what a driving school management system is, how it works, and how it helps manage students, instructors, vehicles, and payments in one dashboard.',
    },
  ],

  blogs: [
    {
      id: 2,
      title: 'How to Manage Driving School Students and Bookings Efficiently',
      category: 'Management',
      date: 'March 12, 2026',
      img: img1,
      description:
        'Discover the best way to manage students, lessons, and bookings using a modern driving school management system.',
    },
    {
      id: 3,
      title: 'How a Dashboard Helps You Track Revenue & Lessons',
      category: 'Business',
      date: 'March 15, 2026',
      img: img2,
      description:
        'A complete guide on how dashboards help driving school owners track revenue, lessons, instructors, and performance.',
    },
    {
      id: 4,
      title: 'Online Booking System for Driving Schools: Complete Guide',
      category: 'Marketing',
      date: 'March 18, 2026',
      img: img3,
      description:
        'Learn how an online booking system can increase bookings and reduce no-shows for driving schools.',
    },
  ],
});
