document.addEventListener('DOMContentLoaded', function () {
  // Contact Form Thank You
  const contactForm = document.getElementById('contactForm');
  const thankYou = document.getElementById('thankYouMessage');
  if (contactForm) {
    contactForm.addEventListener('submit', e => {
      e.preventDefault();
      thankYou.classList.remove('d-none');
      contactForm.reset();
    });
  }

  // Registration
  const registerForm = document.getElementById('registerForm');
  const registerSuccess = document.getElementById('registerSuccess');
  if (registerForm) {
    registerForm.addEventListener('submit', e => {
      e.preventDefault();
      const email = document.getElementById('regEmail').value;
      const pass = document.getElementById('regPassword').value;
      localStorage.setItem('emsUser', JSON.stringify({ email, pass }));
      registerSuccess.classList.remove('d-none');
      registerForm.reset();
    });
  }

  // Login
  const loginForm = document.getElementById('loginForm');
  const loginSuccess = document.getElementById('loginSuccess');
  if (loginForm) {
    loginForm.addEventListener('submit', e => {
      e.preventDefault();
      const stored = JSON.parse(localStorage.getItem('emsUser'));
      const email = document.getElementById('loginEmail').value;
      const pass = document.getElementById('loginPassword').value;
      const passphrase = document.getElementById('loginPassphrase').value.trim();

      if (stored && stored.email === email && stored.pass === pass) {
        loginSuccess.classList.remove('d-none');
        if (passphrase === 'Unihvac123') {
          localStorage.setItem('emsAccess', 'full');
          setTimeout(() => window.location.href = 'ems-sites.html', 1500);
        } else {
          localStorage.setItem('emsAccess', 'limited');
          setTimeout(() => window.location.href = 'ems-sites1.html', 1500);
        }
      } else {
        alert('Invalid credentials or please register first.');
      }
    });
  }

  // Restrict access
  const path = window.location.pathname;
  if (path.includes('ems-sites.html') || path.includes('ems-sites1.html')) {
    const access = localStorage.getItem('emsAccess');
    if (!access) {
      alert('Please log in to access this page.');
      window.location.href = 'login.html';
    }
    if (path.includes('ems-sites.html') && access !== 'full') {
      alert('You do not have permission to view this page.');
      window.location.href = 'ems-sites1.html';
    }
  }
});
