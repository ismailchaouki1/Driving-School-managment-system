// src/contexts/NotificationContext.jsx
import React, { createContext, useContext, useState, useEffect, useCallback } from 'react';
import notificationService from '../services/notificationService';

const NotificationContext = createContext();

export function NotificationProvider({ children }) {
  const [notifications, setNotifications] = useState([]);
  const [paymentReminders, setPaymentReminders] = useState([]);
  const [lastCheckTime, setLastCheckTime] = useState(null);
  const [isInitialized, setIsInitialized] = useState(false);

  // Load notifications from localStorage on mount
  useEffect(() => {
    const saved = localStorage.getItem('notifications');
    if (saved) {
      try {
        setNotifications(JSON.parse(saved));
      } catch (e) {
        console.error('Failed to load notifications:', e);
      }
    }
    setIsInitialized(true);
  }, []);

  // Save notifications to localStorage
  useEffect(() => {
    if (isInitialized) {
      localStorage.setItem('notifications', JSON.stringify(notifications));
    }
  }, [notifications, isInitialized]);

  // Check for pending payments periodically
  const checkPendingPayments = useCallback(async () => {
    const token = localStorage.getItem('token');
    if (!token) return;

    try {
      const reminders = await notificationService.generatePaymentReminders();

      if (reminders && reminders.length > 0) {
        // Filter out existing reminders by checking student id and type
        const newReminders = reminders.filter((r) => {
          return !notifications.some((n) => n.data?.studentId === r.studentId);
        });

        if (newReminders.length > 0) {
          // Play sound for new reminders
          notificationService.playSound();

          const newNotifications = newReminders.map((reminder) => ({
            id: reminder.id,
            title: reminder.title,
            message: reminder.message,
            type: reminder.type === 'payment_overdue' ? 'urgent' : 'payment',
            read: false,
            time: new Date().toISOString(),
            data: reminder,
          }));

          setNotifications((prev) => [...newNotifications, ...prev]);
          setPaymentReminders(reminders);
        }
      }

      setLastCheckTime(new Date().toISOString());
    } catch (error) {
      console.error('Failed to check pending payments:', error);
    }
  }, [notifications]);

  // Check every 10 minutes for pending payments (reduced frequency)
  useEffect(() => {
    const token = localStorage.getItem('token');
    if (!token) return;

    // Initial check after 10 seconds
    const initialTimeout = setTimeout(() => {
      checkPendingPayments();
    }, 10000);

    // Check every 10 minutes
    const interval = setInterval(
      () => {
        checkPendingPayments();
      },
      10 * 60 * 1000,
    );

    return () => {
      clearTimeout(initialTimeout);
      clearInterval(interval);
    };
  }, [checkPendingPayments]);

  const addNotification = (title, message, type = 'info', data = null) => {
    const newNotification = {
      id: Date.now().toString(),
      title,
      message,
      type,
      read: false,
      time: new Date().toISOString(),
      data,
    };

    setNotifications((prev) => [newNotification, ...prev]);

    if (type === 'urgent' || type === 'payment') {
      notificationService.playSound();
    }

    return newNotification.id;
  };

  const markAsRead = (id) => {
    setNotifications((prev) =>
      prev.map((notif) => (notif.id === id ? { ...notif, read: true } : notif)),
    );
  };

  const markAllAsRead = () => {
    setNotifications((prev) => prev.map((notif) => ({ ...notif, read: true })));
  };

  const removeNotification = (id) => {
    setNotifications((prev) => prev.filter((notif) => notif.id !== id));
  };

  const clearAllNotifications = () => {
    setNotifications([]);
  };

  const getUnreadCount = () => {
    return notifications.filter((n) => !n.read).length;
  };

  const refreshPaymentStatus = () => {
    checkPendingPayments();
  };

  return (
    <NotificationContext.Provider
      value={{
        notifications,
        paymentReminders,
        lastCheckTime,
        addNotification,
        markAsRead,
        markAllAsRead,
        removeNotification,
        clearAllNotifications,
        getUnreadCount,
        refreshPaymentStatus,
      }}
    >
      {children}
    </NotificationContext.Provider>
  );
}

// eslint-disable-next-line react-refresh/only-export-components
export const useNotifications = () => useContext(NotificationContext);
