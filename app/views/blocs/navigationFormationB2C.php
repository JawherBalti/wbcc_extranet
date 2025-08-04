<?php
/**
 * Bloc navigation pour formation B2C
 * Identique à la structure B2B mais adapté pour B2C
 */
?>
<!-- Navigation -->
<div class="buttons">
    <button id="prevBtn" type="button" class="btn-prev hidden" onclick="goBackScript()">⬅
        Précédent</button>
    <label for="">Page <span id="indexPage" class="font-weight-bold"></span></label>
    <button id="nextBtn" type="button" class="btn-next" onclick="goNext()">Suivant ➡</button>
    <button id="finishBtn" type="button" class="btn-finish hidden" onclick="finish()">✅
        Terminer</button>
</div>
