console.log('ConfirmLikeButton.js chargé');

document.addEventListener('click', function (e) {
    const btn = e.target.closest('.like-button');
    if (!btn) return;
    const musiqueId = btn.getAttribute('data-id');
    if (!musiqueId) return;
    console.log('Bouton liké cliqué, musiqueId =', musiqueId);

    const isLiked = btn.classList.contains('liked');
    const url = isLiked
        ? '../requete_favoris/delete_favoris'
        : '../requete_favoris/add_favoris';

    fetch(url, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'id_musique=' + encodeURIComponent(musiqueId)
    })
    .then(res => res.text())
    .then(data => {
        btn.classList.toggle('liked');
    });
});

// ✅ Fonction globale pour mettre à jour dynamiquement le bouton "j’aime" dans la navbar
function updateLikeButton(idMusique, estDejaLikee) {
  const likeBtn = document.getElementById('likeBtnInNavbar');
  if (!likeBtn) return;

  likeBtn.setAttribute('data-id', idMusique);

  if (estDejaLikee) {
    likeBtn.classList.add('liked');
  } else {
    likeBtn.classList.remove('liked');
  }
}

