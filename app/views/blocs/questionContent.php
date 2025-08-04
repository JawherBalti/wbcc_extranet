<div class="question-box ">
    <div class="agent-icon">
        <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
    </div>
    <div class="question-content">
        <div <?=$isConsigneHidden ? 'hidden' : ''?> class="tooltip-container btn btn-sm btn-info float-right">
            🧠 Consignes
            <div class="tooltip-content">
                <b>
                    <ul>
                        <?=$consignes?>
                    </ul>
                </b>
            </div>
        </div>

        <div class="question-text">
            <?=$paragraph?>
        </div>
    </div>
</div>