document.addEventListener("DOMContentLoaded", () => {
    const sideNav = document.querySelector('.side-nav');
    const main = document.querySelector('main');
  
    if (sideNav && main) {
      function retractNav() {
        sideNav.classList.add('retracted');
        main.classList.add('retracted');
      }
  
      function expandNav() {
        sideNav.classList.remove('retracted');
        main.classList.remove('retracted');
      }
  
      sideNav.addEventListener('mouseenter', expandNav);
      sideNav.addEventListener('mouseleave', retractNav);
  
      setTimeout(retractNav, 3000);
    }
  });
  function toggleFavorite(musicId) {
    fetch(`../requete_musique/toggle_favori.php?musique_id=${musicId}`, {
        method: 'POST',
        credentials: 'same-origin'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Recharger la page pour mettre à jour la liste
            location.reload();
        }
    })
    .catch(error => console.error('Erreur:', error));
}

const sideNav = document.querySelector('.side-nav');
const main = document.querySelector('main');

// Fonction pour rétracter la navbar
function retractNav() {
    sideNav.classList.add('retracted');
    main.classList.add('retracted');
}

// Fonction pour étendre la navbar
function expandNav() {
    sideNav.classList.remove('retracted');
    main.classList.remove('retracted');
}

// Écouteurs d'événements pour la navbar
sideNav.addEventListener('mouseenter', () => {
    expandNav();
});

sideNav.addEventListener('mouseleave', () => {
    retractNav();
});

// Rétractation initiale après 3 secondes
setTimeout(retractNav, 3000);
// This code listens for the DOMContentLoaded event to ensure that the HTML is fully loaded before executing the script.