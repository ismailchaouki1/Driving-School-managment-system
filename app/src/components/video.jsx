import { useEffect, useRef } from 'react';
import { createPortal } from 'react-dom';
import '../Styles/video.scss';
import vid from '../assets/images/video.mp4';
const videoSrc = vid; // ✅ correct path

export default function Video({ opened, onClose }) {
  const videoRef = useRef(null);

  useEffect(() => {
    if (!opened) return;

    document.body.style.overflow = 'hidden';

    const video = videoRef.current;

    // Force autoplay properly
    const playVideo = async () => {
      try {
        await video.play();
      } catch (error) {
        console.log('Autoplay blocked' + error);
      }
    };

    video.muted = true; // required for autoplay
    playVideo();

    const handleEsc = (e) => {
      if (e.key === 'Escape') onClose();
    };

    document.addEventListener('keydown', handleEsc);

    return () => {
      document.body.style.overflow = 'auto';
      document.removeEventListener('keydown', handleEsc);

      video.pause();
      video.currentTime = 0;
    };
  }, [opened, onClose]);

  if (!opened) return null;

  return createPortal(
    <div className="video-overlay" onClick={onClose}>
      <div className="video-modal" onClick={(e) => e.stopPropagation()}>
        <video
          ref={videoRef}
          src={videoSrc}
          preload="auto"
          controls
          style={{
            width: '75vw',
            maxWidth: '900px',
            maxHeight: '80vh',
          }}
        />
      </div>
    </div>,
    document.body,
  );
}
