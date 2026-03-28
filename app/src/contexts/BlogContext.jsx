import { createContext } from 'react';
import img from '../assets/images/blog1.png';
import img1 from '../assets/images/blog2.jpg';
import img2 from '../assets/images/blog4.jpg';
import img3 from '../assets/images/blog5.jpg';

export const BlogContext = createContext({
  main_blog: [
    {
      id: 1,
      title: 'How to Launch Your SaaS Product With Confidence',
      category: 'Strategy',
      date: 'March 27, 2026',
      img: img,
      description:
        'Learn how to go from idea to launch — fast. We cover positioning, landing pages, early user feedback, and building trust using the Clario template for Planner.',
      fullContent: {
        intro:
          'Learn how to go from idea to launch — fast. We cover positioning, landing pages, early user feedback, and building trust using the Clario template for Planner.',
        sections: [
          {
            title: 'Why Most SaaS Launches Fail (And How You Can Avoid It)',
            content: [
              "Launching a SaaS product is exciting, but it's also where many founders hit a wall. Poor positioning, unclear messaging, and a lackluster landing page are common pitfalls. The good news? These are all solvable with the right strategy and tools.",
              "In this guide, we'll walk through the key steps you need to launch confidently — from refining your idea to building a landing page using our high-converting Clario template built in Planner.",
            ],
          },
          {
            title: '1. Start With a Sharp Positioning Statement',
            content: [
              'Before you even think about designing your site, you need to clearly answer:',
              '• Who is this product for?\n• What problem does it solve?\n• How is it better than alternatives?',
              "Take a few hours to write (and re-write) a one-line statement that captures this. It'll power your landing page headline and keep your messaging focused.",
            ],
          },
          {
            title: '2. Build a Conversion-Focused Landing Page',
            content: [
              'Design plays a massive role in first impressions. With the Clario Planner template, you get a clean, modern layout designed to drive sign-ups and demo requests.',
              'Key features to include:',
              '• Clear hero section with a value-based headline\n• Social proof (testimonials, logos, reviews)\n• Simple pricing blocks\n• Features explained visually\n• Strong call-to-action buttons',
              'The Clario template includes all these sections by default—just plug in your content.',
            ],
          },
          {
            title: '3. Use Early Feedback to Build Trust',
            content: [
              "Don't wait for hundreds of users to refine your messaging. Share your landing page with them and see what they think.",
            ],
          },
        ],
      },
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

      fullContent: {
        intro:
          'Managing students and bookings manually can quickly become overwhelming. A modern system helps you stay organized and efficient.',

        sections: [
          {
            title: 'Why Student Management Is Challenging',
            content: [
              'Driving schools often deal with multiple students, instructors, and schedules at the same time.',
              'Without a proper system, it becomes easy to lose track of lessons and bookings.',
            ],
          },
          {
            title: '1. Centralize Student Data',
            content: [
              'A centralized dashboard allows you to manage all students in one place.',
              '• Track student profiles\n• Monitor lesson history\n• Manage progress easily',
            ],
          },
          {
            title: '2. Automate Bookings',
            content: [
              'An automated booking system reduces manual work and errors.',
              '• Real-time availability\n• Instant confirmations\n• Automated reminders',
            ],
          },
          {
            title: '3. Improve Productivity',
            content: [
              'By automating repetitive tasks, you can focus on growing your business instead of managing operations.',
            ],
          },
        ],
      },
    },

    {
      id: 3,
      title: 'How a Dashboard Helps You Track Revenue & Lessons',
      category: 'Business',
      date: 'March 15, 2026',
      img: img2,
      description:
        'A complete guide on how dashboards help driving school owners track revenue, lessons, instructors, and performance.',

      fullContent: {
        intro:
          'A dashboard gives you a clear overview of your business, helping you make better decisions and grow faster.',

        sections: [
          {
            title: 'Why Data Matters',
            content: [
              'Without proper data, it’s difficult to understand how your business is performing.',
              'Dashboards provide real-time insights into your operations.',
            ],
          },
          {
            title: '1. Track Revenue',
            content: [
              'Monitor your income and identify trends over time.',
              '• Daily and monthly revenue\n• Payment tracking\n• Financial insights',
            ],
          },
          {
            title: '2. Monitor Lessons',
            content: [
              'Keep track of all scheduled and completed lessons.',
              '• Lesson history\n• Instructor schedules\n• Student progress',
            ],
          },
          {
            title: '3. Improve Decision Making',
            content: [
              'With accurate data, you can optimize your business and increase profitability.',
            ],
          },
        ],
      },
    },

    {
      id: 4,
      title: 'Online Booking System for Driving Schools: Complete Guide',
      category: 'Marketing',
      date: 'March 18, 2026',
      img: img3,
      description:
        'Learn how an online booking system can increase bookings and reduce no-shows for driving schools.',

      fullContent: {
        intro:
          'An online booking system helps modern driving schools attract more students and streamline their operations.',

        sections: [
          {
            title: 'Why Online Booking Is Important',
            content: [
              'Customers expect to book services quickly and easily online.',
              'Without it, you risk losing potential students.',
            ],
          },
          {
            title: '1. 24/7 Booking Availability',
            content: [
              'Allow students to book lessons anytime, even outside business hours.',
              '• Increased convenience\n• More bookings\n• Better user experience',
            ],
          },
          {
            title: '2. Reduce No-Shows',
            content: [
              'Automated reminders help reduce missed appointments.',
              '• SMS/email reminders\n• Booking confirmations\n• Easy rescheduling',
            ],
          },
          {
            title: '3. Grow Your Business',
            content: [
              'A professional booking system builds trust and helps you attract more students.',
            ],
          },
        ],
      },
    },
  ],
});
