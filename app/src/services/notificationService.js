// src/services/notificationService.js
import axios from './axios';

class NotificationService {
  constructor() {
    this.audio = null;
    this.initAudio();
    this.isChecking = false; // Prevent concurrent checks
  }

  initAudio() {
    try {
      // Create audio element for notification sound
      this.audio = new Audio('/sounds/notification.mp3');
      this.audio.preload = 'auto';
    } catch (error) {
      console.error('Failed to initialize audio:', error);
    }
  }

  playSound() {
    try {
      if (this.audio) {
        this.audio.currentTime = 0;
        this.audio.play().catch((err) => console.log('Audio play failed:', err));
      }
    } catch (error) {
      console.error('Error playing sound:', error);
    }
  }

  async checkPendingPayments() {
    // Prevent concurrent checks
    if (this.isChecking) return null;

    this.isChecking = true;

    try {
      const token = localStorage.getItem('token');
      if (!token) {
        this.isChecking = false;
        return null;
      }

      const response = await axios.get('/students');
      if (response.data.success) {
        const students = response.data.data;

        const pendingStudents = students.filter(
          (s) => s.payment_status === 'Partial' || s.payment_status === 'Pending',
        );

        const thirtyDaysAgo = new Date();
        thirtyDaysAgo.setDate(thirtyDaysAgo.getDate() - 30);

        const overdueStudents = pendingStudents.filter((s) => {
          const regDate = new Date(s.registration_date);
          return regDate < thirtyDaysAgo;
        });

        this.isChecking = false;

        return {
          pending: pendingStudents,
          overdue: overdueStudents,
          totalPending: pendingStudents.length,
          totalOverdue: overdueStudents.length,
          totalAmount: pendingStudents.reduce(
            (sum, s) => sum + (s.total_price - (s.total_paid || 0)),
            0,
          ),
        };
      }
    } catch (error) {
      console.error('Failed to check pending payments:', error);
      this.isChecking = false;
      return null;
    }

    this.isChecking = false;
    return null;
  }

  async generatePaymentReminders() {
    try {
      const token = localStorage.getItem('token');
      if (!token) return [];

      const data = await this.checkPendingPayments();
      if (!data) return [];

      const reminders = [];

      data.overdue.forEach((student) => {
        const remaining = student.total_price - (student.total_paid || 0);
        reminders.push({
          id: `overdue-${student.id}-${Date.now()}`,
          type: 'payment_overdue',
          title: 'Payment Overdue',
          message: `${student.first_name} ${student.last_name} has overdue payment of ${remaining.toLocaleString()} MAD`,
          studentId: student.id,
          studentName: `${student.first_name} ${student.last_name}`,
          amount: remaining,
          urgency: 'high',
        });
      });

      data.pending.forEach((student) => {
        const remaining = student.total_price - (student.total_paid || 0);
        reminders.push({
          id: `pending-${student.id}-${Date.now()}`,
          type: 'payment_pending',
          title: 'Payment Pending',
          message: `${student.first_name} ${student.last_name} has pending payment of ${remaining.toLocaleString()} MAD`,
          studentId: student.id,
          studentName: `${student.first_name} ${student.last_name}`,
          amount: remaining,
          urgency: 'medium',
        });
      });

      return reminders;
    } catch (error) {
      console.error('Failed to generate reminders:', error);
      return [];
    }
  }
}

export default new NotificationService();
