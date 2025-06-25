<!-- Só o esboço, ainda vou conectar ao BD e acertar as funções etc --> 

<html lang="pt-BR"><head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOUER | Cadastre-se</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#164564',
                        secondary: '#f0fbfe',
                    },
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <style>
        body {
            background-color: #f0fbfe;
            font-family: 'Poppins', sans-serif;
        }
        .input-field {
            transition: all 0.3s ease;
        }
        .input-field:focus {
            border-color: #164564;
            box-shadow: 0 0 0 2px rgba(22, 69, 100, 0.2);
        }
        .btn-primary {
            background-color: #164564;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #0d3854;
        }
        .toggle-button {
            transition: all 0.3s ease;
        }
        .toggle-button.active {
            background-color: #164564;
            color: white;
        }
    </style>
<style>*, ::before, ::after{--tw-border-spacing-x:0;--tw-border-spacing-y:0;--tw-translate-x:0;--tw-translate-y:0;--tw-rotate:0;--tw-skew-x:0;--tw-skew-y:0;--tw-scale-x:1;--tw-scale-y:1;--tw-pan-x: ;--tw-pan-y: ;--tw-pinch-zoom: ;--tw-scroll-snap-strictness:proximity;--tw-gradient-from-position: ;--tw-gradient-via-position: ;--tw-gradient-to-position: ;--tw-ordinal: ;--tw-slashed-zero: ;--tw-numeric-figure: ;--tw-numeric-spacing: ;--tw-numeric-fraction: ;--tw-ring-inset: ;--tw-ring-offset-width:0px;--tw-ring-offset-color:#fff;--tw-ring-color:rgb(59 130 246 / 0.5);--tw-ring-offset-shadow:0 0 #0000;--tw-ring-shadow:0 0 #0000;--tw-shadow:0 0 #0000;--tw-shadow-colored:0 0 #0000;--tw-blur: ;--tw-brightness: ;--tw-contrast: ;--tw-grayscale: ;--tw-hue-rotate: ;--tw-invert: ;--tw-saturate: ;--tw-sepia: ;--tw-drop-shadow: ;--tw-backdrop-blur: ;--tw-backdrop-brightness: ;--tw-backdrop-contrast: ;--tw-backdrop-grayscale: ;--tw-backdrop-hue-rotate: ;--tw-backdrop-invert: ;--tw-backdrop-opacity: ;--tw-backdrop-saturate: ;--tw-backdrop-sepia: ;--tw-contain-size: ;--tw-contain-layout: ;--tw-contain-paint: ;--tw-contain-style: }::backdrop{--tw-border-spacing-x:0;--tw-border-spacing-y:0;--tw-translate-x:0;--tw-translate-y:0;--tw-rotate:0;--tw-skew-x:0;--tw-skew-y:0;--tw-scale-x:1;--tw-scale-y:1;--tw-pan-x: ;--tw-pan-y: ;--tw-pinch-zoom: ;--tw-scroll-snap-strictness:proximity;--tw-gradient-from-position: ;--tw-gradient-via-position: ;--tw-gradient-to-position: ;--tw-ordinal: ;--tw-slashed-zero: ;--tw-numeric-figure: ;--tw-numeric-spacing: ;--tw-numeric-fraction: ;--tw-ring-inset: ;--tw-ring-offset-width:0px;--tw-ring-offset-color:#fff;--tw-ring-color:rgb(59 130 246 / 0.5);--tw-ring-offset-shadow:0 0 #0000;--tw-ring-shadow:0 0 #0000;--tw-shadow:0 0 #0000;--tw-shadow-colored:0 0 #0000;--tw-blur: ;--tw-brightness: ;--tw-contrast: ;--tw-grayscale: ;--tw-hue-rotate: ;--tw-invert: ;--tw-saturate: ;--tw-sepia: ;--tw-drop-shadow: ;--tw-backdrop-blur: ;--tw-backdrop-brightness: ;--tw-backdrop-contrast: ;--tw-backdrop-grayscale: ;--tw-backdrop-hue-rotate: ;--tw-backdrop-invert: ;--tw-backdrop-opacity: ;--tw-backdrop-saturate: ;--tw-backdrop-sepia: ;--tw-contain-size: ;--tw-contain-layout: ;--tw-contain-paint: ;--tw-contain-style: }/* ! tailwindcss v3.4.16 | MIT License | https://tailwindcss.com */*,::after,::before{box-sizing:border-box;border-width:0;border-style:solid;border-color:#e5e7eb}::after,::before{--tw-content:''}:host,html{line-height:1.5;-webkit-text-size-adjust:100%;-moz-tab-size:4;tab-size:4;font-family:Poppins, sans-serif;font-feature-settings:normal;font-variation-settings:normal;-webkit-tap-highlight-color:transparent}body{margin:0;line-height:inherit}hr{height:0;color:inherit;border-top-width:1px}abbr:where([title]){-webkit-text-decoration:underline dotted;text-decoration:underline dotted}h1,h2,h3,h4,h5,h6{font-size:inherit;font-weight:inherit}a{color:inherit;text-decoration:inherit}b,strong{font-weight:bolder}code,kbd,pre,samp{font-family:ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;font-feature-settings:normal;font-variation-settings:normal;font-size:1em}small{font-size:80%}sub,sup{font-size:75%;line-height:0;position:relative;vertical-align:baseline}sub{bottom:-.25em}sup{top:-.5em}table{text-indent:0;border-color:inherit;border-collapse:collapse}button,input,optgroup,select,textarea{font-family:inherit;font-feature-settings:inherit;font-variation-settings:inherit;font-size:100%;font-weight:inherit;line-height:inherit;letter-spacing:inherit;color:inherit;margin:0;padding:0}button,select{text-transform:none}button,input:where([type=button]),input:where([type=reset]),input:where([type=submit]){-webkit-appearance:button;background-color:transparent;background-image:none}:-moz-focusring{outline:auto}:-moz-ui-invalid{box-shadow:none}progress{vertical-align:baseline}::-webkit-inner-spin-button,::-webkit-outer-spin-button{height:auto}[type=search]{-webkit-appearance:textfield;outline-offset:-2px}::-webkit-search-decoration{-webkit-appearance:none}::-webkit-file-upload-button{-webkit-appearance:button;font:inherit}summary{display:list-item}blockquote,dd,dl,figure,h1,h2,h3,h4,h5,h6,hr,p,pre{margin:0}fieldset{margin:0;padding:0}legend{padding:0}menu,ol,ul{list-style:none;margin:0;padding:0}dialog{padding:0}textarea{resize:vertical}input::placeholder,textarea::placeholder{opacity:1;color:#9ca3af}[role=button],button{cursor:pointer}:disabled{cursor:default}audio,canvas,embed,iframe,img,object,svg,video{display:block;vertical-align:middle}img,video{max-width:100%;height:auto}[hidden]:where(:not([hidden=until-found])){display:none}.container{width:100%}@media (min-width: 640px){.container{max-width:640px}}@media (min-width: 768px){.container{max-width:768px}}@media (min-width: 1024px){.container{max-width:1024px}}@media (min-width: 1280px){.container{max-width:1280px}}@media (min-width: 1536px){.container{max-width:1536px}}.mx-auto{margin-left:auto;margin-right:auto}.mb-1{margin-bottom:0.25rem}.mb-3{margin-bottom:0.75rem}.mb-4{margin-bottom:1rem}.mb-8{margin-bottom:2rem}.ml-2{margin-left:0.5rem}.mt-1{margin-top:0.25rem}.mt-6{margin-top:1.5rem}.mt-auto{margin-top:auto}.block{display:block}.flex{display:flex}.hidden{display:none}.h-4{height:1rem}.min-h-screen{min-height:100vh}.w-4{width:1rem}.w-full{width:100%}.max-w-2xl{max-width:42rem}.flex-grow{flex-grow:1}.flex-col{flex-direction:column}.items-start{align-items:flex-start}.items-center{align-items:center}.justify-center{justify-content:center}.justify-between{justify-content:space-between}.space-x-4 > :not([hidden]) ~ :not([hidden]){--tw-space-x-reverse:0;margin-right:calc(1rem * var(--tw-space-x-reverse));margin-left:calc(1rem * calc(1 - var(--tw-space-x-reverse)))}.space-x-6 > :not([hidden]) ~ :not([hidden]){--tw-space-x-reverse:0;margin-right:calc(1.5rem * var(--tw-space-x-reverse));margin-left:calc(1.5rem * calc(1 - var(--tw-space-x-reverse)))}.space-y-5 > :not([hidden]) ~ :not([hidden]){--tw-space-y-reverse:0;margin-top:calc(1.25rem * calc(1 - var(--tw-space-y-reverse)));margin-bottom:calc(1.25rem * var(--tw-space-y-reverse))}.overflow-hidden{overflow:hidden}.rounded{border-radius:0.25rem}.rounded-2xl{border-radius:1rem}.rounded-lg{border-radius:0.5rem}.border{border-width:1px}.border-t{border-top-width:1px}.border-gray-200{--tw-border-opacity:1;border-color:rgb(229 231 235 / var(--tw-border-opacity, 1))}.border-gray-300{--tw-border-opacity:1;border-color:rgb(209 213 219 / var(--tw-border-opacity, 1))}.bg-white{--tw-bg-opacity:1;background-color:rgb(255 255 255 / var(--tw-bg-opacity, 1))}.p-8{padding:2rem}.px-3{padding-left:0.75rem;padding-right:0.75rem}.px-4{padding-left:1rem;padding-right:1rem}.py-1{padding-top:0.25rem;padding-bottom:0.25rem}.py-10{padding-top:2.5rem;padding-bottom:2.5rem}.py-3{padding-top:0.75rem;padding-bottom:0.75rem}.py-4{padding-top:1rem;padding-bottom:1rem}.py-6{padding-top:1.5rem;padding-bottom:1.5rem}.text-center{text-align:center}.text-2xl{font-size:1.5rem;line-height:2rem}.text-3xl{font-size:1.875rem;line-height:2.25rem}.text-sm{font-size:0.875rem;line-height:1.25rem}.text-xs{font-size:0.75rem;line-height:1rem}.font-bold{font-weight:700}.font-medium{font-weight:500}.text-gray-500{--tw-text-opacity:1;color:rgb(107 114 128 / var(--tw-text-opacity, 1))}.text-gray-600{--tw-text-opacity:1;color:rgb(75 85 99 / var(--tw-text-opacity, 1))}.text-gray-700{--tw-text-opacity:1;color:rgb(55 65 81 / var(--tw-text-opacity, 1))}.text-primary{--tw-text-opacity:1;color:rgb(22 69 100 / var(--tw-text-opacity, 1))}.text-white{--tw-text-opacity:1;color:rgb(255 255 255 / var(--tw-text-opacity, 1))}.shadow-lg{--tw-shadow:0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);--tw-shadow-colored:0 10px 15px -3px var(--tw-shadow-color), 0 4px 6px -4px var(--tw-shadow-color);box-shadow:var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)}.shadow-sm{--tw-shadow:0 1px 2px 0 rgb(0 0 0 / 0.05);--tw-shadow-colored:0 1px 2px 0 var(--tw-shadow-color);box-shadow:var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)}.hover\:text-primary:hover{--tw-text-opacity:1;color:rgb(22 69 100 / var(--tw-text-opacity, 1))}.hover\:underline:hover{-webkit-text-decoration-line:underline;text-decoration-line:underline}.focus\:outline-none:focus{outline:2px solid transparent;outline-offset:2px}.focus\:ring-primary:focus{--tw-ring-opacity:1;--tw-ring-color:rgb(22 69 100 / var(--tw-ring-opacity, 1))}@media (min-width: 768px){.md\:mb-0{margin-bottom:0px}.md\:flex{display:flex}.md\:flex-row{flex-direction:row}.md\:p-10{padding:2.5rem}.md\:px-6{padding-left:1.5rem;padding-right:1.5rem}.md\:py-16{padding-top:4rem;padding-bottom:4rem}.md\:text-3xl{font-size:1.875rem;line-height:2.25rem}}</style></head>
<body>
    <div class="min-h-screen flex flex-col">
        <!-- Navbar -->
        <nav class="bg-white shadow-sm py-4">
            <div class="container mx-auto px-4 md:px-6 flex justify-between items-center">
                <a href="#" class="text-primary font-bold text-3xl">LOUER</a>
                <div class="hidden md:flex space-x-6">
                    <a href="#" class="text-gray-600 hover:text-primary">Início</a>
                    <a href="#" class="text-gray-600 hover:text-primary">Espaços</a>
                    <a href="#" class="text-gray-600 hover:text-primary">Itens</a>
                    <a href="#" class="text-gray-600 hover:text-primary">Ajuda</a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="#" class="text-gray-600 hover:text-primary">Entrar</a>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="flex-grow container mx-auto px-4 py-10 md:py-16 flex justify-center">
            <!-- Sign Up Form - Card mais largo -->
            <div class="w-full max-w-2xl">
                <div class="bg-white rounded-2xl shadow-lg p-8 md:p-10">
                    <h1 class="text-2xl md:text-3xl font-bold text-primary mb-3">Crie sua conta</h1>
                    <p class="text-gray-600 mb-8">Junte-se ao LOUER e comece a alugar ou disponibilizar espaços e itens.</p>
                    
                    <!-- Sign Up Form -->
                    <form id="signupForm">
                        <div class="space-y-5">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nome completo</label>
                                <input type="text" id="name" name="name" class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none" placeholder="Seu nome completo" required="">
                            </div>
                            
                            <!-- CPF ou CNPJ com toggle -->
                            <div>
                                <div class="flex justify-between items-center mb-1">
                                    <label class="block text-sm font-medium text-gray-700">Documento</label>
                                    <div class="flex border border-gray-300 rounded-lg overflow-hidden">
                                        <button type="button" id="cpfToggle" class="toggle-button px-3 py-1 text-sm focus:outline-none active">CPF</button>
                                        <button type="button" id="cnpjToggle" class="toggle-button px-3 py-1 text-sm focus:outline-none">CNPJ</button>
                                    </div>
                                </div>
                                <input type="text" id="documentInput" name="document" class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none" placeholder="000.000.000-00" required="" data-type="cpf">
                            </div>
                            
                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-700 mb-1">Cidade</label>
                                <input type="text" id="city" name="city" class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none" placeholder="Sua cidade" required="">
                            </div>
                            
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Telefone</label>
                                <input type="tel" id="phone" name="phone" class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none" placeholder="(00) 00000-0000" required="">
                            </div>
                            
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input type="email" id="email" name="email" class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none" placeholder="seu@email.com" required="">
                            </div>
                            
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Senha</label>
                                <input type="password" id="password" name="password" class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none" placeholder="Crie uma senha" required="">
                                <p class="mt-1 text-xs text-gray-500">Mínimo de 8 caracteres com letras e números</p>
                            </div>
                            
                            <div>
                                <label for="confirmPassword" class="block text-sm font-medium text-gray-700 mb-1">Confirme sua senha</label>
                                <input type="password" id="confirmPassword" name="confirmPassword" class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none" placeholder="Digite sua senha novamente" required="">
                            </div>
                            
                            <div class="flex items-start">
                                <input type="checkbox" id="terms" name="terms" class="mt-1 h-4 w-4 text-primary border-gray-300 rounded focus:ring-primary" required="">
                                <label for="terms" class="ml-2 block text-sm text-gray-600">
                                    Concordo com os <a href="#" class="text-primary hover:underline">Termos de Serviço</a> e <a href="#" class="text-primary hover:underline">Política de Privacidade</a> do LOUER
                                </label>
                            </div>
                            
                            <div>
                                <button type="submit" class="btn-primary w-full py-3 px-4 rounded-lg text-white font-medium">
                                    Criar conta
                                </button>
                            </div>
                        </div>
                    </form>

                    <p class="mt-6 text-center text-gray-600">
                        Já tem uma conta? <a href="#" class="text-primary font-medium hover:underline">Entrar</a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-white py-6 border-t border-gray-200 mt-auto">
            <div class="container mx-auto px-4 md:px-6">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="mb-4 md:mb-0">
                        <a href="#" class="text-primary font-bold text-2xl">LOUER</a>
                        <p class="mt-1 text-gray-600 text-sm">Alugue espaços e itens de forma simples.</p>
                    </div>
                    <p class="text-gray-500 text-sm">© 2023 LOUER. Todos os direitos reservados.</p>
                </div>
            </div>
        </footer>
    </div>

    <script>
        // Toggle entre CPF e CNPJ
        const cpfToggle = document.getElementById('cpfToggle');
        const cnpjToggle = document.getElementById('cnpjToggle');
        const documentInput = document.getElementById('documentInput');
        
        cpfToggle.addEventListener('click', function() {
            cpfToggle.classList.add('active');
            cnpjToggle.classList.remove('active');
            documentInput.placeholder = '000.000.000-00';
            documentInput.setAttribute('data-type', 'cpf');
        });
        
        cnpjToggle.addEventListener('click', function() {
            cnpjToggle.classList.add('active');
            cpfToggle.classList.remove('active');
            documentInput.placeholder = '00.000.000/0000-00';
            documentInput.setAttribute('data-type', 'cnpj');
        });
        
        // Inicializar como CPF
        documentInput.setAttribute('data-type', 'cpf');
        
        // Máscara para CPF e CNPJ
        documentInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            const type = e.target.getAttribute('data-type');
            
            if (type === 'cpf') {
                if (value.length > 11) value = value.slice(0, 11);
                
                if (value.length > 9) {
                    value = value.replace(/^(\d{3})(\d{3})(\d{3})(\d{2}).*/, '$1.$2.$3-$4');
                } else if (value.length > 6) {
                    value = value.replace(/^(\d{3})(\d{3})(\d{0,3}).*/, '$1.$2.$3');
                } else if (value.length > 3) {
                    value = value.replace(/^(\d{3})(\d{0,3}).*/, '$1.$2');
                }
            } else {
                if (value.length > 14) value = value.slice(0, 14);
                
                if (value.length > 12) {
                    value = value.replace(/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2}).*/, '$1.$2.$3/$4-$5');
                } else if (value.length > 8) {
                    value = value.replace(/^(\d{2})(\d{3})(\d{3})(\d{0,4}).*/, '$1.$2.$3/$4');
                } else if (value.length > 5) {
                    value = value.replace(/^(\d{2})(\d{3})(\d{0,3}).*/, '$1.$2.$3');
                } else if (value.length > 2) {
                    value = value.replace(/^(\d{2})(\d{0,3}).*/, '$1.$2');
                }
            }
            
            e.target.value = value;
        });
        
        // Máscara para telefone
        document.getElementById('phone').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            
            if (value.length > 11) value = value.slice(0, 11);
            
            if (value.length > 10) {
                value = value.replace(/^(\d{2})(\d{5})(\d{4}).*/, '($1) $2-$3');
            } else if (value.length > 6) {
                value = value.replace(/^(\d{2})(\d{4})(\d{0,4}).*/, '($1) $2-$3');
            } else if (value.length > 2) {
                value = value.replace(/^(\d{2})(\d{0,5}).*/, '($1) $2');
            }
            
            e.target.value = value;
        });
        
        // Validação do formulário
        document.getElementById('signupForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const name = document.getElementById('name').value;
            const document = documentInput.value;
            const city = document.getElementById('city').value;
            const phone = document.getElementById('phone').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            const documentType = documentInput.getAttribute('data-type');
            
            // Validar campos vazios
            if (!name || !document || !city || !phone || !email || !password || !confirmPassword) {
                alert('Por favor, preencha todos os campos obrigatórios.');
                return;
            }
            
            // Validar senha
            if (password.length < 8) {
                alert('A senha deve ter pelo menos 8 caracteres.');
                return;
            }
            
            // Verificar se as senhas coincidem
            if (password !== confirmPassword) {
                alert('As senhas não coincidem.');
                return;
            }
            
            // Validar CPF/CNPJ
            const documentValue = document.replace(/\D/g, '');
            if (documentType === 'cpf' && documentValue.length !== 11) {
                alert('Por favor, insira um CPF válido.');
                return;
            } else if (documentType === 'cnpj' && documentValue.length !== 14) {
                alert('Por favor, insira um CNPJ válido.');
                return;
            }
            
            // Validar formato de email
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                alert('Por favor, insira um email válido.');
                return;
            }
            
            // Simulação de cadastro bem-sucedido
            alert('Cadastro realizado com sucesso! Bem-vindo ao LOUER, ' + name + '!');
            
            // Limpar formulário
            this.reset();
            cpfToggle.click(); // Reset para CPF
        });
    </script>
<script>(function(){function c(){var b=a.contentDocument||a.contentWindow.document;if(b){var d=b.createElement('script');d.innerHTML="window.__CF$cv$params={r:'94ea2f0b53ffcaf6',t:'MTc0OTc0MDA3MC4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";b.getElementsByTagName('head')[0].appendChild(d)}}if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);else{var e=document.onreadystatechange||function(){};document.onreadystatechange=function(b){e(b);'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();</script><iframe height="1" width="1" style="position: absolute; top: 0px; left: 0px; border: none; visibility: hidden;"></iframe>

</body></html>