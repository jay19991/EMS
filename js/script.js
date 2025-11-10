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
  // Restrict access for EMS Sites
        if (passphrase === 'Unihvac123') {
          localStorage.setItem('emsAccess', 'full');
          setTimeout(() => window.location.href = 'ems-sites.html', 1500);
        } 
  // Restrict access for Portfolio
		else if (passphrase === 'Unihvac@123') {
          localStorage.setItem('emsAccess', 'full');
          setTimeout(() => window.location.href = 'https://jay19991.github.io/portfolio/', 1500);
        }
		else {
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

//Procedure Page
//BAS Step by Step Procedures 
const stepDetails = {
  1: {description: "<ul><li>Define project scope and goals</li><li>Conduct site surveys</li><li>Prepare project charter</li></ul>"},
  2: {description: "<ul><li>Design network architecture</li><li>Select sensors/controllers</li><li>Prepare control logic</li></ul>"},
  3: {description: "<ul><li>Create wiring diagrams</li><li>Develop I/O lists</li><li>Prepare Bill of Materials</li></ul>"},
  4: {description: "<ul><li>Assemble panels</li><li>Develop software</li><li>Integrate systems</li></ul>"},
  5: {description: "<ul><li>Install sensors and controllers</li><li>Cable termination</li><li>Ensure compliance</li></ul>"},
  6: {description: "<ul><li>Point-to-point tests</li><li>Calibrate devices</li><li>System acceptance</li></ul>"},
  7: {description: "<ul><li>Submit documentation</li><li>Train staff</li><li>Obtain client sign-off</li></ul>"},
  8: {description: "<ul><li>Perform preventive maintenance</li><li>Monitor performance</li><li>Implement updates</li></ul>"}
};

// Show description below each step on click
document.querySelectorAll(".flow-node").forEach(node => {
  node.addEventListener("click", () => {
    const stepId = node.dataset.step;
    const descDiv = node.querySelector(".step-desc");

    descDiv.style.width = node.querySelector(".content").offsetWidth + "px";
    descDiv.innerHTML = stepDetails[stepId].description;
    descDiv.style.display = "block";

    drawCurves();

    setTimeout(() => {
      descDiv.style.display = "none";
      drawCurves();
    }, 10000);
  });
});

// Animate nodes sequentially
window.addEventListener("load", () => {
  const nodes = document.querySelectorAll(".flow-node");
  nodes.forEach((node, index) => {
    setTimeout(() => {
      node.classList.add("visible", "animate__animated", "animate__fadeInUp");
    }, index * 400);
  });

  drawCurves();
});

// Draw smooth responsive curved lines relative to container
function drawCurves() {
  const nodes = document.querySelectorAll(".flow-node");
  const svg = document.querySelector('.flow-svg');
  const containerRect = svg.parentElement.getBoundingClientRect();

  nodes.forEach((node, i) => {
    const curve = document.getElementById(`curve${i+1}`);
    if(!curve || i === nodes.length-1) return;

    const start = node.getBoundingClientRect();
    const end = nodes[i+1].getBoundingClientRect();

    let x1 = start.left + start.width/2 - containerRect.left;
    let y1 = start.top + start.height/2 - containerRect.top;
    let x2 = end.left + end.width/2 - containerRect.left;
    let y2 = end.top + end.height/2 - containerRect.top;

    // Smooth curve control points
    const dx = (x2 - x1) / 2;
    const dy = Math.min(Math.abs(y2 - y1)/2, 100);

    const cx1 = x1 + dx;
    const cy1 = y1;
    const cx2 = x2 - dx;
    const cy2 = y2;

    curve.setAttribute("d", `M ${x1} ${y1} C ${cx1} ${cy1}, ${cx2} ${cy2}, ${x2} ${y2}`);
    curve.style.strokeDasharray = curve.getTotalLength();
    curve.style.strokeDashoffset = curve.getTotalLength();
    curve.style.animation = `drawCurve 1.5s forwards ${i*0.3}s`;
  });
}

// Redraw curves on window resize
window.addEventListener('resize', drawCurves);


