import '../Styles/Home.scss';
import Header from '../components/Header';
import HeroSection from '../components/HeroSection';

export default function HomePage() {
  return (
    <div className="mainContainer">
      <header className="header container-xl">
        <Header />
      </header>

      <section className="hero container-xl">
        <HeroSection />
      </section>
    </div>
  );
}
