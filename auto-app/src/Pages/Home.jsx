import "../Styles/Home.scss";
import "../Styles/App.scss";
import Header from "../components/Header";
import HeroSection from "../components/HeroSection";
export default function HomePage() {
  return (
    <div className="mainContainer">
      <div className="container container-fluid heroSection">
        <Header />
        <HeroSection />
      </div>
    </div>
  );
}
