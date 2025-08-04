<div class="response-options">
    <div class="options-container">
        <?php foreach($options as $option): ?>
            <button onclick="<?= $option['onclick'] ?>selectRadio(this);" type="button" 
                    class="option-button btn btn-<?= $option['btn_class'] ?>">
                <div class="option-circle">
                    <input id="<?=isset($option['id']) ? $option['id'] : ''?>" type="radio" class="btn-check" 
                           name="<?= $name ?>" 
                           value="<?= $option['value'] ?>"
                           <?= checked($name, $option['value'], $questScript, 'checked') ?> />
                </div>
                <?= $option['label'] ?>
            </button>
            <?php endforeach; ?>
    </div>
</div>