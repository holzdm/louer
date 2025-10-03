
<?php if (!empty($_GET['msg'])): ?>
            <div id="notificacao" class="fixed top-5 left-1/2 transform -translate-x-1/2 z-50 fade-in">
                <div class="bg-white border border-green-300 text-green-600 rounded-lg p-4 shadow-lg flex items-start max-w-md w-full">
                    <svg class="w-6 h-6 text-green-600 mt-1 mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2a10 10 0 1 1 0 20 10 10 0 0 1 0-20zm0 14a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm1-8h-2v6h2V8z" />
                    </svg>
                    <div>
                        <!-- <p class="font-medium text-sm">Erro no cadastro</p>  Tirei pra poder receber varias mensagens, n so as de erro de cadastro -->
                        <p class="text-sm text-gray-600"><?= htmlspecialchars($_GET['msg']) ?></p>
                    </div>
                </div>
            </div>

            <style>
                @keyframes fadeIn {
                    from {
                        opacity: 0;
                        transform: translate(-50%, -10px);
                    }

                    to {
                        opacity: 1;
                        transform: translate(-50%, 0);
                    }
                }

                @keyframes fadeOut {
                    from {
                        opacity: 1;
                        transform: translate(-50%, 0);
                    }

                    to {
                        opacity: 0;
                        transform: translate(-50%, -10px);
                    }
                }

                .fade-in {
                    animation: fadeIn 0.4s ease-out forwards;
                }

                .fade-out {
                    animation: fadeOut 0.4s ease-in forwards;
                }
            </style>

            <script>
                setTimeout(() => {
                    const notif = document.getElementById('notificacao');
                    if (notif) {
                        notif.classList.remove('fade-in');
                        notif.classList.add('fade-out');
                        setTimeout(() => notif.remove(), 500);
                    }
                }, 4000);
            </script>
        <?php endif; ?>