<div class="buttons">
    <button id="prevBtn<?= $section ?>" type="button" class="btn-prev hidden" onclick="goBackScript('<?= $section ?>')">
        ⬅ Précédent
    </button>
    <label for="">Page <span id="indexPage<?= $section ?>" class="font-weight-bold"></span></label>
    <button id="nextBtn<?= $section ?>" type="button" class="btn-next" onclick="goNext('<?= $section ?>')">
        Suivant ➡
    </button>
    <button id="finishBtn<?= $section ?>" type="button" class="btn-finish hidden" onclick="finish('<?= $section ?>')">
        ✅ Terminer
    </button>
</div>