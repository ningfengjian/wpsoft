(function ($) {
  const searchInput = document.querySelector('.wpsoft-search input[type="search"]');
  const suggestionContainer = document.createElement('div');
  suggestionContainer.className = 'wpsoft-search-suggestions';

  if (searchInput && window.wpsoftData) {
    searchInput.parentNode.appendChild(suggestionContainer);

    let debounceTimer;

    searchInput.addEventListener('input', function () {
      const value = this.value.trim();
      clearTimeout(debounceTimer);

      if (!value) {
        suggestionContainer.innerHTML = '';
        suggestionContainer.style.display = 'none';
        return;
      }

      debounceTimer = setTimeout(function () {
        fetch(`${wpsoftData.ajaxEndpoint}?q=${encodeURIComponent(value)}`)
          .then((response) => response.json())
          .then((results) => {
            if (!Array.isArray(results) || !results.length) {
              suggestionContainer.style.display = 'none';
              suggestionContainer.innerHTML = '';
              return;
            }

            suggestionContainer.style.display = 'block';
            suggestionContainer.innerHTML = results
              .map(
                (item) => `
                  <a class="suggestion" href="${item.link}">
                    <span class="title">${item.title}</span>
                    <span class="type">${item.type}</span>
                  </a>
                `
              )
              .join('');
          })
          .catch(() => {
            suggestionContainer.style.display = 'none';
          });
      }, 250);
    });

    document.addEventListener('click', function (event) {
      if (!suggestionContainer.contains(event.target) && event.target !== searchInput) {
        suggestionContainer.style.display = 'none';
      }
    });
  }

  $('.menu-toggle').on('click', function () {
    const menu = document.getElementById($(this).attr('aria-controls'));
    menu.classList.toggle('toggled-on');
    const expanded = $(this).attr('aria-expanded') === 'true';
    $(this).attr('aria-expanded', !expanded);
  });
})(jQuery);
