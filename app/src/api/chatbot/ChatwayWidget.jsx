import { useEffect } from 'react';

export default function ChatwayWidget() {
  useEffect(() => {
    // Create script element
    const script = document.createElement('script');
    script.id = 'chatway';
    script.src = 'https://cdn.chatway.app/widget.js?id=bRF6Re0AMd3g';
    script.async = true;

    // Append it to the body
    document.body.appendChild(script);

    // Optional: Cleanup when component unmounts
    return () => {
      document.body.removeChild(script);
    };
  }, []);

  return null; // This component only loads the script
}
