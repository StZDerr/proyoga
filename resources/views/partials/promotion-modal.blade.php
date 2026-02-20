<div class="promotion-modal" id="promotionModal">
    <div class="promotion-modal-content">
        <span class="promotion-modal-close">&times;</span>
        <img id="promotionModalImage" src="" alt="">
        <h2 id="promotionModalTitle"></h2>
        <p id="promotionModalDescription"></p>
        <p class="promotion-modal-dates"></p>
    </div>
</div>


<style>
    .promotion-modal {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.6);
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    .promotion-modal-content {
        background: #fff;
        border-radius: 16px;
        padding: 20px;
        max-width: 600px;
        width: 90%;
        text-align: left;
        position: relative;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        animation: fadeInUp 0.3s ease;
    }

    .promotion-modal-content img {
        width: 100%;
        border-radius: 12px;
        margin-bottom: 15px;
    }

    .promotion-modal-close {
        position: absolute;
        top: 10px;
        right: 15px;
        font-size: 28px;
        cursor: pointer;
        color: #666;
    }

    #promotionModalDescription {
        white-space: pre-wrap;
    }

    @keyframes fadeInUp {
        from {
            transform: translateY(20px);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
</style>
