<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cosmic Companion</title>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap" rel="stylesheet">

  <link rel="icon" type="image/jpg" href="<?= base_url('public/astro.jpg') ?>">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Nunito', sans-serif;
      background: linear-gradient(135deg, #0f0f23, #1a1a2e, #16213e, #0f3460);
      background-size: 400% 400%;
      background-attachment: fixed;
      animation: deepGradientMove 25s ease infinite;
      min-height: 100vh;
      overflow-x: hidden;
      position: relative;
    }

    @keyframes deepGradientMove {
      0% { background-position: 0% 50%; }
      25% { background-position: 100% 50%; }
      50% { background-position: 100% 100%; }
      75% { background-position: 0% 100%; }
      100% { background-position: 0% 50%; }
    }

    .stars, .particles, #backgroundOrbs {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      pointer-events: none;
      z-index: 0;
    }

    .star, .particle {
      position: absolute;
      border-radius: 50%;
    }

    .star {
      width: 2px;
      height: 2px;
      background: rgba(255, 255, 255, 0.8);
      animation: twinkle 4s infinite ease-in-out;
    }

    .star:nth-child(2n) { background: rgba(147, 197, 253, 0.6); animation-delay: 1s; }
    .star:nth-child(3n) { background: rgba(196, 181, 253, 0.6); animation-delay: 2s; }
    .star:nth-child(4n) { background: rgba(134, 239, 172, 0.6); animation-delay: 3s; }

    @keyframes twinkle {
      0%, 100% { opacity: 0.2; transform: scale(1); }
      50% { opacity: 1; transform: scale(1.5); }
    }

    .orb {
      position: absolute;
      border-radius: 50%;
      background: radial-gradient(circle at 30% 30%, rgba(147, 197, 253, 0.3), rgba(59, 130, 246, 0.1));
      animation: floatOrb 20s infinite ease-in-out;
      filter: blur(1px);
    }

    @keyframes floatOrb {
      0%, 100% { transform: translate(0, 0) scale(1); opacity: 0.3; }
      33% { transform: translate(50px, -30px) scale(1.2); opacity: 0.6; }
      66% { transform: translate(-30px, 50px) scale(0.8); opacity: 0.4; }
    }

    .particle {
      width: 3px;
      height: 3px;
      background: rgba(255, 255, 255, 0.5);
      animation: particleFloat 15s infinite linear;
    }

    @keyframes particleFloat {
      0% {
        transform: translateY(100vh) translateX(0) scale(0);
        opacity: 0;
      }
      10% { opacity: 1; }
      90% { opacity: 1; }
      100% {
        transform: translateY(-10vh) translateX(100px) scale(1);
        opacity: 0;
      }
    }

    .container {
      position: relative;
      z-index: 10;
      text-align: center;
      max-width: 600px;
      margin: 10vh auto;
      padding: 40px;
      background: rgba(25, 25, 45, 0.95);
      border-radius: 25px;
      backdrop-filter: blur(8px);
      border: 1px solid rgba(255, 255, 255, 0.1);
      animation: fadeInUp 2s ease both;
    }

    @keyframes fadeInUp {
      0% {
        opacity: 0;
        transform: translateY(60px) scale(0.9);
      }
      100% {
        opacity: 1;
        transform: translateY(0) scale(1);
      }
    }

    h1 {
      font-size: 2rem;
      margin-bottom: 25px;
      color: #fff;
    }

    .container h1 {
  color: #f3f4f6;
  text-align: center;
  margin-bottom: 30px;
  font-size: 2.2rem;
  text-shadow: 0 0 15px rgba(255, 255, 255, 0.3);
}

.guide-tile-container {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 20px;
  padding: 0 20px;
}

.guide-tile {
  display: flex;
  align-items: center;
  background: rgba(25, 25, 45, 0.85);
  backdrop-filter: blur(6px);
  border: 1px solid rgba(255, 255, 255, 0.08);
  border-radius: 16px;
  padding: 12px 20px;
  min-width: 240px;
  max-width: 300px;
  cursor: pointer;
  transition: all 0.3s ease;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
}

.guide-tile:hover {
  transform: translateY(-4px);
  box-shadow: 0 12px 30px rgba(59, 130, 246, 0.3);
}

.emoji-icon {
  font-size: 2rem;
  margin-right: 15px;
  display: flex;
  align-items: center;
  justify-content: center;
  width: 48px;
  height: 48px;
  border-radius: 12px;
  background: rgba(255, 255, 255, 0.05);
  text-shadow: 0 0 8px rgba(255, 255, 255, 0.2);
}

.guide-info h2 {
  font-size: 1.2rem;
  margin: 0;
  color: #f3f4f6;
}

.guide-info p {
  font-size: 0.9rem;
  color: #9ca3af;
  margin: 4px 0 0;
}

.step-indicator {
  color: #a5b4fc;
  font-size: 0.95rem;
  margin-bottom: 12px;
  text-align: center;
  letter-spacing: 0.5px;
  text-shadow: 0 0 6px rgba(165, 180, 252, 0.3);
  animation: glowStep 2s ease-in-out infinite alternate;
}

@keyframes glowStep {
  0% { text-shadow: 0 0 6px rgba(165, 180, 252, 0.2); }
  100% { text-shadow: 0 0 12px rgba(165, 180, 252, 0.5); }
}


  </style>
</head>
<body>
  <div class="stars" id="stars"></div>
  <div id="backgroundOrbs">
    <div class="orb" style="left:10%;top:20%;width:80px;height:80px;"></div>
    <div class="orb" style="left:80%;top:10%;width:60px;height:60px;background: radial-gradient(circle at 30% 30%, rgba(196, 181, 253, 0.3), rgba(139, 92, 246, 0.1));"></div>
    <div class="orb" style="left:70%;top:70%;width:100px;height:100px;background: radial-gradient(circle at 30% 30%, rgba(134, 239, 172, 0.3), rgba(34, 197, 94, 0.1));"></div>
    <div class="orb" style="left:20%;top:80%;width:50px;height:50px;background: radial-gradient(circle at 30% 30%, rgba(251, 191, 36, 0.3), rgba(245, 158, 11, 0.1));"></div>
  </div>
  <div class="particles" id="particles"></div>

  <div class="container">
    <div class="step-indicator">Step 1 of 2: Choose your Companion</div>

  <h1>🌌 Choose Your Cosmic Companion</h1>
  <div class="guide-tile-container">
    <div class="guide-tile" onclick="selectVoice('Healer')">
      <div class="emoji-icon">🌿</div>
      <div class="guide-info">
        <h2>Healer</h2>
        <p>Calm & nurturing</p>
      </div>
    </div>

    <div class="guide-tile" onclick="selectVoice('Warrior')">
      <div class="emoji-icon">⚔️</div>
      <div class="guide-info">
        <h2>Warrior</h2>
        <p>Bold & fearless</p>
      </div>
    </div>

    <div class="guide-tile" onclick="selectVoice('Dreamer')">
      <div class="emoji-icon">🌙</div>
      <div class="guide-info">
        <h2>Dreamer</h2>
        <p>Creative & hopeful</p>
      </div>
    </div>

    <div class="guide-tile" onclick="selectVoice('Sage')">
      <div class="emoji-icon">🧘</div>
      <div class="guide-info">
        <h2>Sage</h2>
        <p>Wise & grounded</p>
      </div>
    </div>
  </div>
</div>

<footer style="text-align:center; font-size:14px; padding:10px; color:#888;">
    &copy; 2025 <strong>Bot Tech</strong> by Girish Raskar. All rights reserved.
  </footer>

  <script>
    function selectVoice(voice) {
      localStorage.setItem('cosmic_selected_voice', voice);
      window.location.href = "/cosmic-local/first";
    }

    // generate stars
    const stars = document.getElementById('stars');
    for (let i = 0; i < 100; i++) {
      const star = document.createElement('div');
      star.className = 'star';
      star.style.left = Math.random() * 100 + '%';
      star.style.top = Math.random() * 100 + '%';
      star.style.animationDelay = Math.random() * 4 + 's';
      stars.appendChild(star);
    }

    // generate particles
    const particles = document.getElementById('particles');
    for (let i = 0; i < 20; i++) {
      const particle = document.createElement('div');
      particle.className = 'particle';
      particle.style.left = Math.random() * 100 + '%';
      particle.style.animationDelay = Math.random() * 15 + 's';
      particle.style.animationDuration = (Math.random() * 10 + 10) + 's';
      particles.appendChild(particle);
    }
  </script>
</body>
</html>