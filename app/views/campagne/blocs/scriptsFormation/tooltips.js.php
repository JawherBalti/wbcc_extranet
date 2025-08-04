<?php
/**
 * Bloc JavaScript - Gestion des tooltips pour formation
 */
?>
<script>
document.addEventListener('click', function(e) {
    const allTooltips = document.querySelectorAll('.tooltip-content');
    let clickedOnTooltip = false;

    document.querySelectorAll('.tooltip-container').forEach(container => {
        const content = container.querySelector('.tooltip-content');

        if (container.contains(e.target)) {
            clickedOnTooltip = true;

            // Toggle pinned state
            if (content.classList.contains('pinned')) {
                content.classList.remove('pinned');
            } else {
                allTooltips.forEach(t => t.classList.remove('pinned'));
                content.classList.add('pinned');

                // Gérer la position dynamiquement
                const rect = content.getBoundingClientRect();
                const spaceAbove = rect.top;
                const spaceBelow = window.innerHeight - rect.bottom;

                // Si pas assez de place au-dessus, ouvrir vers le bas
                if (spaceAbove < 100 && spaceBelow > spaceAbove) {
                    content.style.top = '125%';
                    content.style.bottom = 'auto';
                    content.style.transform = 'translateX(-50%)';
                } else {
                    content.style.bottom = '125%';
                    content.style.top = 'auto';
                }
            }
        }
    });

    if (!clickedOnTooltip) {
        allTooltips.forEach(t => t.classList.remove('pinned'));
    }
});
</script>
