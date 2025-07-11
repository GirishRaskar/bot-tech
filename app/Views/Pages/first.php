<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Cosmic Friend</title>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap" rel="stylesheet">

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
      position: relative;
      overflow-x: hidden;
    }

    @keyframes deepGradientMove {
      0% { background-position: 0% 50%; }
      25% { background-position: 100% 50%; }
      50% { background-position: 100% 100%; }
      75% { background-position: 0% 100%; }
      100% { background-position: 0% 50%; }
    }

    /* Animated stars background */
    .stars {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: 0;
      overflow: hidden;
    }

    .star {
      position: absolute;
      width: 2px;
      height: 2px;
      background: rgba(255, 255, 255, 0.8);
      border-radius: 50%;
      animation: twinkle 4s infinite ease-in-out;
    }

    .star:nth-child(2n) {
      animation-delay: 1s;
      background: rgba(147, 197, 253, 0.6);
    }

    .star:nth-child(3n) {
      animation-delay: 2s;
      background: rgba(196, 181, 253, 0.6);
    }

    .star:nth-child(4n) {
      animation-delay: 3s;
      background: rgba(134, 239, 172, 0.6);
    }

    @keyframes twinkle {
      0%, 100% { opacity: 0.2; transform: scale(1); }
      50% { opacity: 1; transform: scale(1.5); }
    }

    /* Floating orbs */
    #backgroundOrbs {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: 1;
      overflow: hidden;
    }

    .orb {
      position: absolute;
      border-radius: 50%;
      background: radial-gradient(circle at 30% 30%, rgba(147, 197, 253, 0.3), rgba(59, 130, 246, 0.1));
      animation: floatOrb 20s infinite ease-in-out;
      filter: blur(1px);
    }

    .orb:nth-child(1) {
      width: 80px;
      height: 80px;
      left: 10%;
      top: 20%;
      animation-duration: 25s;
    }

    .orb:nth-child(2) {
      width: 60px;
      height: 60px;
      left: 80%;
      top: 10%;
      animation-duration: 30s;
      background: radial-gradient(circle at 30% 30%, rgba(196, 181, 253, 0.3), rgba(139, 92, 246, 0.1));
    }

    .orb:nth-child(3) {
      width: 100px;
      height: 100px;
      left: 70%;
      top: 70%;
      animation-duration: 35s;
      background: radial-gradient(circle at 30% 30%, rgba(134, 239, 172, 0.3), rgba(34, 197, 94, 0.1));
    }

    .orb:nth-child(4) {
      width: 50px;
      height: 50px;
      left: 20%;
      top: 80%;
      animation-duration: 18s;
      background: radial-gradient(circle at 30% 30%, rgba(251, 191, 36, 0.3), rgba(245, 158, 11, 0.1));
    }

    @keyframes floatOrb {
      0%, 100% { transform: translate(0, 0) scale(1); opacity: 0.3; }
      33% { transform: translate(50px, -30px) scale(1.2); opacity: 0.6; }
      66% { transform: translate(-30px, 50px) scale(0.8); opacity: 0.4; }
    }

    /* Particle system */
    .particles {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: 1;
      pointer-events: none;
    }

    .particle {
      position: absolute;
      width: 3px;
      height: 3px;
      background: rgba(255, 255, 255, 0.5);
      border-radius: 50%;
      animation: particleFloat 15s infinite linear;
    }

    @keyframes particleFloat {
      0% {
        transform: translateY(100vh) translateX(0) scale(0);
        opacity: 0;
      }
      10% {
        opacity: 1;
      }
      90% {
        opacity: 1;
      }
      100% {
        transform: translateY(-10vh) translateX(100px) scale(1);
        opacity: 0;
      }
    }

    #userThought {
      position: relative;
      background: rgba(25, 25, 45, 0.95);
      backdrop-filter: blur(8px);
      border: 1px solid rgba(255, 255, 255, 0.15);
      padding: 50px;
      border-radius: 25px;
      box-shadow: 
        0 30px 60px rgba(0, 0, 0, 0.6),
        0 0 50px rgba(59, 130, 246, 0.1),
        inset 0 1px 0 rgba(255, 255, 255, 0.1);
      max-width: 600px;
      width: 90%;
      margin: 5vh auto;
      text-align: center;
      z-index: 10;
      animation: fadeInUp 2s ease both;
      position: relative;
      overflow: hidden;
    }

    #userThought::before {
      content: '';
      position: absolute;
      top: -2px;
      left: -2px;
      right: -2px;
      bottom: -2px;
      background: linear-gradient(45deg, #3b82f6, #8b5cf6, #10b981, #f59e0b);
      background-size: 400% 400%;
      animation: borderGlow 3s linear infinite;
      border-radius: 25px;
      z-index: -1;
      opacity: 0.3;
    }

    @keyframes borderGlow {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
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
      font-size: 2.2rem;
      margin-bottom: 30px;
      color: #f3f4f6;
      text-shadow: 0 0 20px rgba(59, 130, 246, 0.5);
      animation: titlePulse 3s ease-in-out infinite;
    }

    @keyframes titlePulse {
      0%, 100% { text-shadow: 0 0 20px rgba(59, 130, 246, 0.5); }
      50% { text-shadow: 0 0 30px rgba(59, 130, 246, 0.8), 0 0 50px rgba(139, 92, 246, 0.4); }
    }

    label {
      display: block;
      font-size: 1.1rem;
      margin-bottom: 12px;
      color: #e5e7eb;
      text-shadow: 0 0 10px rgba(255, 255, 255, 0.3);
    }

    input[type="text"] {
      padding: 16px 20px;
      border: 2px solid rgba(255, 255, 255, 0.2);
      border-radius: 15px;
      width: 100%;
      margin-bottom: 25px;
      font-size: 1.1rem;
      background: rgba(40, 40, 60, 0.8);
      color: #f3f4f6;
      backdrop-filter: blur(5px);
      transition: all 0.3s ease;
      outline: none;
    }

    input[type="text"]:focus {
      border-color: #3b82f6;
      box-shadow: 
        0 0 20px rgba(59, 130, 246, 0.4),
        0 0 40px rgba(59, 130, 246, 0.2),
        inset 0 0 20px rgba(59, 130, 246, 0.1);
      background: rgba(50, 50, 70, 0.9);
      transform: translateY(-2px);
    }

    input[type="text"]::placeholder {
      color: #9ca3af;
    }

    button {
      background: linear-gradient(45deg, #3b82f6, #8b5cf6, #10b981);
      background-size: 300% 300%;
      color: white;
      padding: 16px 40px;
      border: none;
      border-radius: 15px;
      font-size: 1.1rem;
      font-weight: bold;
      cursor: pointer;
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
      animation: buttonGlow 4s ease-in-out infinite;
      box-shadow: 
        0 10px 30px rgba(59, 130, 246, 0.3),
        0 0 20px rgba(59, 130, 246, 0.2);
      text-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
    }

    @keyframes buttonGlow {
      0%, 100% { 
        background-position: 0% 50%;
        box-shadow: 
          0 10px 30px rgba(59, 130, 246, 0.3),
          0 0 20px rgba(59, 130, 246, 0.2);
      }
      50% { 
        background-position: 100% 50%;
        box-shadow: 
          0 15px 40px rgba(139, 92, 246, 0.4),
          0 0 30px rgba(139, 92, 246, 0.3);
      }
    }

    button:hover {
      transform: translateY(-3px) scale(1.05);
      box-shadow: 
        0 20px 50px rgba(59, 130, 246, 0.4),
        0 0 40px rgba(59, 130, 246, 0.3);
    }

    button:active {
      transform: translateY(-1px) scale(1.02);
    }

    button::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
      transition: left 0.5s ease;
    }

    button:hover::before {
      left: 100%;
    }

    #appendThought {
      margin-top: 40px;
      font-size: 1.3rem;
      font-weight: bold;
      color: #f3f4f6;
      background: rgba(59, 130, 246, 0.15);
      backdrop-filter: blur(8px);
      border: 1px solid rgba(59, 130, 246, 0.3);
      padding: 25px;
      border-radius: 20px;
      box-shadow: 
        0 0 30px rgba(59, 130, 246, 0.2),
        inset 0 1px 0 rgba(255, 255, 255, 0.1);
      display: none;
      opacity: 0;
      text-shadow: 0 0 10px rgba(255, 255, 255, 0.3);
      line-height: 1.6;
    }

    .spinner {
      border: 3px solid rgba(255, 255, 255, 0.3);
      border-top: 3px solid #3b82f6;
      border-radius: 50%;
      width: 18px;
      height: 18px;
      animation: spin 1s linear infinite;
      display: inline-block;
      vertical-align: middle;
      margin-right: 10px;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    #toggle-music-btn {
      position: fixed;
      top: 20px;
      right: 20px;
      background: rgba(59, 130, 246, 0.2);
      border: 1px solid rgba(59, 130, 246, 0.4);
      color: #f3f4f6;
      padding: 10px 20px;
      border-radius: 10px;
      cursor: pointer;
      font-size: 14px;
      transition: all 0.3s ease;
      z-index: 1000;
      display: none;
      backdrop-filter: blur(5px);
    }

    #toggle-music-btn:hover {
      background: rgba(59, 130, 246, 0.3);
      transform: translateY(-2px);
    }

    /* Demo audio since we can't load external files */
    .demo-note {
      margin-top: 20px;
      padding: 15px;
      background: rgba(251, 191, 36, 0.1);
      border: 1px solid rgba(251, 191, 36, 0.3);
      border-radius: 10px;
      font-size: 0.9rem;
      color: #fbbf24;
      text-align: center;
    }

    /* Responsive design */
    @media (max-width: 768px) {
      #userThought {
        padding: 30px;
        margin: 2vh auto;
      }
      
      h1 {
        font-size: 1.8rem;
      }
      
      input[type="text"] {
        padding: 14px 18px;
        font-size: 1rem;
      }
      
      button {
        padding: 14px 30px;
        font-size: 1rem;
      }

      #toggle-music-btn {
        top: 15px;
        right: 15px;
        padding: 8px 16px;
        font-size: 12px;
      }
    }

    /* Add some bottom padding for scrollable content */
    body::after {
      content: '';
      display: block;
      height: 5vh;
    }
  </style>
</head>

<body>
  <!-- Animated stars -->
  <div class="stars" id="stars"></div>
  
  <!-- Floating orbs -->
  <div id="backgroundOrbs">
    <div class="orb"></div>
    <div class="orb"></div>
    <div class="orb"></div>
    <div class="orb"></div>
  </div>

  <!-- Floating particles -->
  <div class="particles" id="particles"></div>

  <!-- Music toggle button (hidden initially) -->
  <button type="button" id="toggle-music-btn">🔇 Stop Music</button>

  <div id="userThought">
    <form id="thoughtForm">
      <h1>🌟 Your Cosmic Companion</h1>
      <label for="userInp">Share what's weighing on your soul...</label>
      <input name="userInp" id="userInp" type="text" placeholder="e.g. I'm feeling lost in the darkness..." />
      <button type="submit" id="illuminate-btn">✨ Illuminate My Path</button>
    </form>

    <div id="appendThought"></div>
    
    <!-- <div class="demo-note">
      🎵 For demo purposes, music will play when you click "Illuminate My Path"<br>
      (Make sure your audio file is at <code>/music/interstellar.mp3</code>)
    </div> -->
  </div>

  <!-- Audio element with corrected path -->
  <audio id="bg-music" loop preload="auto">
    <source src="public/music/interstellar.mp3" type="audio/mpeg">
    <!-- <source src="https://www.soundjay.com/misc/sounds/bell-ringing-05.wav" type="audio/wav"> -->
    Your browser does not support the audio element.
  </audio>

  <footer style="text-align:center; font-size:14px; padding:10px; color:#888;">
    &copy; 2025 <strong>Bot Tech</strong> by Girish Raskar. All rights reserved.
  </footer>


  <script>
    // Generate random stars
    function createStars() {
      const starsContainer = document.getElementById('stars');
      for (let i = 0; i < 100; i++) {
        const star = document.createElement('div');
        star.className = 'star';
        star.style.left = Math.random() * 100 + '%';
        star.style.top = Math.random() * 100 + '%';
        star.style.animationDelay = Math.random() * 4 + 's';
        starsContainer.appendChild(star);
      }
    }

    // Generate floating particles
    function createParticles() {
      const particlesContainer = document.getElementById('particles');
      for (let i = 0; i < 20; i++) {
        const particle = document.createElement('div');
        particle.className = 'particle';
        particle.style.left = Math.random() * 100 + '%';
        particle.style.animationDelay = Math.random() * 15 + 's';
        particle.style.animationDuration = (Math.random() * 10 + 10) + 's';
        particlesContainer.appendChild(particle);
      }
    }

    // Placeholder typing effect
    function createTypingEffect() {
      const placeholderText = "e.g. I'm feeling lost in the darkness...";
      const input = document.querySelector("input[placeholder]");
      let i = 0;

      function typeEffect() {
        if (i < placeholderText.length) {
          input.setAttribute("placeholder", placeholderText.slice(0, i + 1));
          i++;
          setTimeout(typeEffect, 70);
        } else {
          setTimeout(() => {
            input.setAttribute("placeholder", "");
            i = 0;
            setTimeout(typeEffect, 1000);
          }, 2500);
        }
      }

      typeEffect();
    }

    // Initialize background effects
    createStars();
    createParticles();
    createTypingEffect();

    // Music control functionality
    document.addEventListener("DOMContentLoaded", function () {
      console.log("DOM loaded");
      
      const audio = document.getElementById("bg-music");
      const illuminateBtn = document.getElementById("illuminate-btn");
      const toggleBtn = document.getElementById("toggle-music-btn");
      const thoughtForm = document.getElementById("thoughtForm");

      console.log("Audio element:", audio);
      console.log("Illuminate button:", illuminateBtn);
      console.log("Toggle button:", toggleBtn);

      let musicStarted = false;

      // Handle form submission and music
      if (thoughtForm && illuminateBtn) {
        thoughtForm.addEventListener("submit", function(e) {
          e.preventDefault();
          
          console.log("Form submitted, illuminate button clicked");
          
          // Start music if not already started
          if (!musicStarted && audio) {
            audio.volume = 0.3;
            audio.play().then(() => {
              console.log("Music started successfully");
              musicStarted = true;
              toggleBtn.style.display = "block";
            }).catch(e => {
              console.error("Audio playback failed:", e);
              // Show a message to user about audio failure
              const demoNote = document.querySelector('.demo-note');
              demoNote.innerHTML = '🎵 Audio file not found. Please ensure your music file is at <code>/music/interstellar.mp3</code>';
            });
          }

          // Handle the form submission for getting motivation
          const formData = new FormData(this);
          const $button = $(illuminateBtn);
          const $thought = $("#appendThought");

          $button.prop('disabled', true).html('<span class="spinner"></span> Channeling cosmic wisdom...');
          $thought.fadeOut(300);

          $.ajax({
          type: 'POST',
          url: '<?=base_url('/generate')?>',
          data: formData,
          processData: false,
          contentType: false,
          dataType: 'JSON',

          success: function (res) {
            $thought
              .html("🌌 " + res.message)
              .css({ 
                display: 'block', 
                opacity: 0, 
                transform: 'translateY(20px) scale(0.9)' 
              })
              .animate({ 
                opacity: 1 
              }, 600)
              .animate({
                transform: 'translateY(0) scale(1)'
              }, 400);

            $button.prop('disabled', false).html('✨ Illuminate My Path');
          },

          error: function () {
            $thought
              .html("⚡ The cosmic connection flickered. Let's try again...")
              .css({ 
                display: 'block', 
                opacity: 0, 
                transform: 'translateY(20px) scale(0.9)' 
              })
              .animate({ 
                opacity: 1 
              }, 600)
              .animate({
                transform: 'translateY(0) scale(1)'
              }, 400);

            $button.prop('disabled', false).html('✨ Illuminate My Path');
          }
        });
        });
      }

      // Toggle music button functionality
      if (toggleBtn) {
        toggleBtn.addEventListener("click", function () {
          console.log("Toggle button clicked");
          if (!audio) return;

          if (audio.paused) {
            audio.play().then(() => {
              toggleBtn.innerHTML = "🔇 Stop Music";
            }).catch(e => {
              console.error("Resume audio failed:", e);
            });
          } else {
            audio.pause();
            toggleBtn.innerHTML = "🔊 Play Music";
          }
        });
      }

      // Add focus effect to input
      const userInput = document.getElementById('userInp');
      if (userInput) {
        userInput.addEventListener('focus', function() {
          this.parentElement.classList.add('focused');
        });
        userInput.addEventListener('blur', function() {
          this.parentElement.classList.remove('focused');
        });
      }
    });
  </script>
  
  <script>
  $(document).ready(function () {
    // Call backend visit counter silently
    $.ajax({
      url: "<?= base_url('/visit-count') ?>",
      method: "POST"
    });
  });
</script>

</body>
</html>