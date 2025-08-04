<?php
/**
 * Bloc styles CSS pour Proxinistre B2B
 */
?>
<style>
/* Styles pour le système de navigation par étapes */
/* Note: Les .step ne sont plus utilisés dans ce contexte */

.stepDSS,
.stepSD,
.stepRvRT,
.stepRvPerso {
    display: none;
}

.stepDSS.active,
.stepSD.active,
.stepRvRT.active,
.stepRvPerso.active {
    display: block;
    animation: fadeIn 0.3s ease-in-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }

    to {
        opacity: 1;
    }
}

.buttons {
    margin-top: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 0;
    border-top: 1px solid #dee2e6;
}

button {
    padding: 10px 20px;
    border: none;
    border-radius: 20px;
    font-size: 16px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-prev {
    background-color: rgb(78, 123, 172);
    color: #ffffff;
}

.btn-prev:hover {
    background-color: rgb(65, 105, 150);
}

.btn-next {
    background-color: #007BFF;
    color: white;
}

.btn-next:hover {
    background-color: #0056b3;
}

.btn-finish {
    background-color: #28a745;
    color: white;
}

.btn-finish:hover {
    background-color: #218838;
}

.hidden {
    display: none;
}

#sinistreForm {
    font-size: 18px;
}

/* Styles spécifiques aux questions */
.question-box {
    display: flex;
    align-items: flex-start;
    margin-bottom: 20px;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 10px;
    border-left: 4px solid #007bff;
}

.agent-icon {
    margin-right: 15px;
    flex-shrink: 0;
}

.question-content {
    flex: 1;
}

.question-text {
    margin-bottom: 15px;
}

.response-options {
    margin-left: 65px;
}

.options-container {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 20px;
}

.option-button {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 20px;
    border: 2px solid #ddd;
    border-radius: 25px;
    background: white;
    cursor: pointer;
    transition: all 0.3s ease;
    min-width: 120px;
}

.option-button:hover {
    border-color: #007bff;
    background: #f0f8ff;
}

.option-button.selected {
    border-color: #007bff;
    background: #007bff;
    color: white;
}

.option-circle {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    border: 2px solid #ddd;
    display: flex;
    align-items: center;
    justify-content: center;
}

.option-button.selected .option-circle {
    border-color: white;
    background: white;
}

.script-container {
    background: white;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

/* Styles pour les formulaires */
.form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
}

/* Animation pour les transitions */
.fade-in {
    animation: fadeIn 0.5s ease-in-out;
}

/* Styles pour les badges */
.badge {
    font-size: 0.9em;
}

/* Styles pour les cartes */
.card {
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;
}

.card-body {
    padding: 1.25rem;
}

/* Responsive */
@media (max-width: 768px) {
    .question-box {
        flex-direction: column;
    }
    
    .agent-icon {
        margin-right: 0;
        margin-bottom: 10px;
    }
    
    .response-options {
        margin-left: 0;
    }
    
    .options-container {
        flex-direction: column;
    }
    
    .option-button {
        width: 100%;
        justify-content: flex-start;
    }
}
</style>
