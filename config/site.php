<?php

/*
|--------------------------------------------------------------------------
| Conteúdo institucional — Solution Business BPO
|--------------------------------------------------------------------------
|
| Todos os textos, contatos e imagens do site ficam centralizados aqui.
| Os textos foram recuperados do site original (www.solutionbpo.com.br)
| e preservados integralmente. Ver docs/inventario-conteudo.md.
|
| Para alterar um contato ou texto, edite somente este arquivo e rode
| `lando artisan optimize:clear` (ou `php artisan config:cache` em produção).
|
*/

$whatsappNumber = '5513996338514';

return [

    'name' => 'Solution Business BPO',
    'short_name' => 'Solution BPO',

    'seo' => [
        'title' => 'Solution Business BPO | BPO Financeiro em Santos/SP',
        'description' => 'Terceirizando a gestão financeira com a Solution Business BPO você mantém as finanças de sua empresa em dia e investe o seu tempo nas atividades principais da sua empresa.',
        'og_image' => 'assets/images/banners/banner3.png',
        'og_image_width' => 1366,
        'og_image_height' => 525,
        'locale' => 'pt_BR',
    ],

    'contact' => [
        'phone_display' => '(13) 99633-8514',
        'phone_e164' => '+'.$whatsappNumber,
        'whatsapp_number' => $whatsappNumber,
        'whatsapp_url' => 'https://wa.me/'.$whatsappNumber,
        // Mensagem pré-preenchida do botão flutuante (comportamento do site original).
        'whatsapp_float_message' => 'Quero mais informações sobre:',
        'email' => 'contato@solutionbpo.com.br',
        'instagram_url' => 'https://www.instagram.com/solution.bpofinanceira/',
        'instagram_handle' => '@solution.bpofinanceira',
        'website_display' => 'www.solutionbpo.com.br',
        'website_url' => 'https://www.solutionbpo.com.br',
        'address' => [
            'display' => 'Av. Washington Luis, 61 - cj. 32 - VL Mathias - Santos/SP',
            'street' => 'Av. Washington Luis, 61 - cj. 32',
            'district' => 'Vila Mathias',
            'city' => 'Santos',
            'state' => 'SP',
            'country' => 'BR',
        ],
        'maps_embed_url' => 'https://maps.google.com/maps?q=Av.%20Washington%20Luis,%2061%20-%20cj.%2032%20-%20VL%20Mathias%20-%20Santos/SP&t=&z=15&ie=UTF8&iwloc=&output=embed',
        'maps_url' => 'https://www.google.com/maps/search/?api=1&query=Av.+Washington+Luis,+61+-+Vila+Mathias,+Santos+-+SP',
    ],

    'navigation' => [
        ['label' => 'Início', 'href' => '#inicio'],
        ['label' => 'Serviços', 'href' => '#servicos'],
        ['label' => 'Como Funciona', 'href' => '#como-funciona'],
        ['label' => 'Sobre Nós', 'href' => '#sobre-nos'],
        ['label' => 'Depoimentos', 'href' => '#depoimentos'],
        ['label' => 'FAQ', 'href' => '#faq'],
    ],

    /*
    | Banner rotativo — slides originais, na mesma ordem do site antigo.
    | Os textos ficam gravados nas imagens; o "alt" reproduz esse texto.
    */
    'slides' => [
        [
            'image' => 'assets/images/banners/banner3',
            'alt' => 'Sua empresa é a nossa prioridade — Gestão de contas a pagar.',
        ],
        [
            'image' => 'assets/images/banners/banner4',
            'alt' => 'A sua empresa lucra o quanto deveria lucrar? Você já usou o cheque especial na sua empresa? Você controla cada centavo que entra e que sai no seu negócio? Já pagou conta pessoal com dinheiro da empresa? De forma fácil consegue saber qual o lucro gerado pelo seu negócio? A sua empresa possui planejamento financeiro? A sua empresa possui reserva financeira?',
        ],
        [
            'image' => 'assets/images/banners/banner5',
            'alt' => 'BPO Financeiro: uma revolução sem precedentes para o crescimento da sua empresa.',
        ],
        [
            'image' => 'assets/images/banners/banner6',
            'alt' => 'Saiba como vamos te ajudar: início; controlar cada centavo que entra e que sai; prestar informações que indiquem o caminho do crescimento; vamos te ajudar a lucrar mais; relatório de fluxo de caixa para acompanhamento.',
        ],
    ],
    'slide_width' => 1366,
    'slide_height' => 525,

    'benefits' => [
        'title' => 'Quanto tempo você perde toda semana com as burocracias do seu financeiro?',
        'intro' => 'Terceirizando a gestão financeira com a Solution Business BPO você mantém as finanças de sua empresa em dia e investe o seu tempo nas atividades principais da sua empresa.',
        'items' => [
            [
                'icon' => 'assets/icons/beneficios/icon-experts.png',
                'title' => 'Conte com experts',
                'text' => 'Você pode contar com um time de profissionais altamente especializado e experiente para cuidar das finanças por você.',
            ],
            [
                'icon' => 'assets/icons/beneficios/icon-gastos.png',
                'title' => 'Reduza seus gastos',
                'text' => 'A vantagem de terceirizar é que você paga bem menos para poder ter equipe, sistemas, equipamentos e outros.',
            ],
            [
                'icon' => 'assets/icons/beneficios/icon-gerenciamento-de-tempo.png',
                'title' => 'Tenha mais tempo para seu negócio',
                'text' => 'O tempo que você economizará com o BPO financeiro você poderá focar em áreas-chave da sua empresa.',
            ],
        ],
    ],

    'services' => [
        'eyebrow' => 'Nossos Serviços',
        'title' => 'Cuidamos de sua operação financeira para você crescer',
        'intro' => 'Na Solution Business BPO você escolhe quais tarefas do Departamento Financeiro quer terceirizar.',
        'items' => [
            [
                'id' => 'faturamento',
                'tab' => 'Gestão de Faturamento',
                'icon' => 'assets/icons/ui/icon-moedas.png',
                'title' => 'Gestão de Faturamento',
                'highlights' => [
                    'Cuidamos da emissão de notas fiscais e boletos.',
                    'Gerenciamos o contas a receber e projetamos seu fluxo de caixa.',
                    'Além disso, assumimos a responsabilidade de cobrar os inadimplentes.',
                ],
                'we_do' => [
                    'Cadastro de produtos e serviços',
                    'Registro de contratos com clientes',
                    'Emissão de notas fiscais',
                    'Geração de boletos',
                    'Conciliação do contas a receber',
                    'E muito mais!',
                ],
                'client_label' => 'O que você faz:',
                'client' => ['Basta enviar os contratos de contas a receber.'],
                'image' => 'assets/images/servicos/img-gestao-faturamento',
                'image_ext' => 'jpg',
                'image_size' => [400, 280],
                'image_alt' => 'Profissional segurando ícones de dinheiro e relógio, representando a gestão de faturamento.',
            ],
            [
                'id' => 'contas-a-pagar',
                'tab' => 'Gestão de Contas a Pagar',
                'icon' => 'assets/icons/ui/icon-conta.png',
                'title' => 'Gestão de Contas a Pagar',
                'highlights' => [
                    'Deixe a gestão das suas contas conosco. Garantimos que você nunca perca um prazo, evitando multas e penalidades. Sempre trabalhando com transparência em conjunto com você!',
                ],
                'we_do' => [
                    'Cadastro de fornecedores',
                    'Registro de compras',
                    'Inclusão de novas contas a pagar',
                    'Programação de pagamentos',
                    'Conciliação bancária',
                    'E muito mais!',
                ],
                'client_label' => 'Você ainda recebe:',
                'client' => ['Relatórios detalhados e análises financeiras que ajudam você a tomar decisões. Com dados precisos em mãos, você pode planejar o futuro do seu negócio com confiança'],
                'image' => 'assets/images/servicos/img-contas-pagar',
                'image_ext' => 'jpg',
                'image_size' => [400, 280],
                'image_alt' => 'Profissional analisando documentos financeiros e usando o celular, representando a gestão de contas a pagar.',
            ],
            [
                'id' => 'integracao-contabil',
                'tab' => 'Integração Contábil',
                'icon' => 'assets/icons/ui/icon-contabil.png',
                'title' => 'Integração Contábil',
                'highlights' => [
                    'Organizamos os documentos contábeis tornando a integração de dados financeiros e fiscais mais segura para sua empresa.',
                ],
                'we_do' => [
                    'Geração de arquivos para integração contábil',
                    'Relatórios financeiros',
                    'Conciliação bancária',
                    'Envio dos arquivos para o seu escritório contábil',
                    'E muito mais!',
                ],
                'client_label' => 'O que você faz:',
                'client' => ['Nada, pois cuidamos de tudo por aqui!'],
                'image' => 'assets/images/servicos/img-integracao-contabil',
                'image_ext' => 'jpg',
                'image_size' => [187, 280],
                'image_alt' => 'Mãos segurando um globo digital com ícones de dados, representando a integração contábil.',
            ],
            [
                'id' => 'relatorios-analises',
                'tab' => 'Relatórios e Análises',
                'icon' => 'assets/icons/ui/icon-relatorio.png',
                'title' => 'Relatórios, Análises e Serviços Especiais',
                'highlights' => [
                    'Oferecemos informações em tempo real e gerenciamos sua gestão financeira produzindo relatórios financeiros avançados, incluindo DRE Gerencial e Fluxo de Caixa.',
                ],
                'we_do' => [
                    'Gerar informações para tomada de decisão em tempo real',
                    'Gerenciar o sistema financeiro',
                    'Elaborar relatórios financeiros avançados, como DRE Gerencial e Fluxo de Caixa',
                    'Dashboard de BI',
                    'E muito mais!',
                ],
                'client_label' => 'O que você faz:',
                'client' => ['Apenas participe de reuniões com nosso time para analisar relatórios financeiros e tomar decisões'],
                'image' => 'assets/images/servicos/img-relatorios-analises',
                'image_ext' => 'jpg',
                'image_size' => [400, 280],
                'image_alt' => 'Notebook exibindo gráficos e painéis financeiros, representando relatórios e análises.',
            ],
        ],
    ],

    'workflow' => [
        'eyebrow' => 'Como funciona',
        'title' => 'Veja abaixo como a Solution Business BPO simplifica seu dia a dia',
        'intro' => 'Não permita que a administração financeira da sua empresa se torne um obstáculo para focar no que é realmente importante.',
        'steps' => [
            [
                'icon' => 'assets/icons/passos/icon-passo1.png',
                'title' => 'Envie suas contas a pagar e a receber',
                'text' => 'Deixe a tarefa de inserir os dados financeiros no sistema de contas a pagar e receber por nossa conta, economizando tempo e com controle total dos vencimentos.',
            ],
            [
                'icon' => 'assets/icons/passos/icon-passo2.png',
                'title' => 'Simplificamos a emissão de notas fiscais e boletos',
                'text' => 'Você nos fornece os dados e nós cuidamos de todo o processo enviando diretamente para o e-mail dos seus clientes.',
            ],
            [
                'icon' => 'assets/icons/passos/icon-passo3.png',
                'title' => 'Acesse diariamente o status das contas a pagar e a receber',
                'text' => 'Nunca mais seja pego de surpresa com contas de alto valor e caixa insuficiente para pagamento, deixando seus clientes inadimplentes.',
            ],
            [
                'icon' => 'assets/icons/passos/icon-passo4.png',
                'title' => 'Agendamos seus pagamentos bancários',
                'text' => 'Com um usuário e senha exclusivos garantimos que todas as contas a pagar sejam agendadas no seu internet banking.',
            ],
            [
                'icon' => 'assets/icons/passos/icon-passo5.png',
                'title' => 'Você tem o controle total dos agendamentos',
                'text' => 'Diariamente, fornecemos um relatório das contas a pagar para você autorizar os pagamentos que agendamos.',
            ],
        ],
    ],

    'cta' => [
        'title' => 'Comece agora!',
        'paragraphs' => [
            'Trabalhando em conjunto com você, analisamos o desempenho do seu negócio.',
            'Mostramos para onde cada centavo está indo e avaliamos se o seu negócio está prosperando ou enfrentando desafios.',
        ],
        'highlight' => 'Tenha o controle das finanças da sua empresa!',
        'button' => 'Fale com um Especialista',
        'whatsapp_message' => 'Olá! Gostaria de falar com um especialista da Solution BPO.',
    ],

    'about' => [
        'eyebrow' => 'Sobre Nós',
        'title' => 'Solution Business BPO, sua parceira em finanças',
        'paragraphs' => [
            'Há, aproximadamente, 10 anos oferecendo BPO financeiro, nossa missão é superar suas expectativas, oferecendo soluções ágeis, éticas e altamente profissionais, sempre focadas em seu sucesso financeiro.',
            'Valorizamos parcerias de longo prazo, priorizando o atendimento excepcional e o suporte contínuo para os nossos clientes alcançarem seus objetivos empresariais.',
        ],
        'closing' => 'Confie em nós para a gestão financeira de sua empresa!',
    ],

    'director' => [
        'name' => 'Flávia Jacob',
        'role' => 'Diretora',
        'photo' => 'assets/images/institucional/flavia-jacob',
        'photo_size' => [200, 300],
        // Texto original preservado. Não atualizar anos de experiência sem confirmação do cliente.
        'bio' => [
            'Diretora da Solution BPO, com 5 anos de experiência em Finanças, atuando na gestão e otimização de processos financeiros. Formada em Administração e Ciências Contábeis, com especializações em Direito do Trabalho e Direito Imobiliário, o que permite uma visão estratégica e abrangente nas áreas de atuação.',
            'Comprometida em proporcionar soluções eficientes e inovadoras, busca constantemente o desenvolvimento da equipe e a excelência nos serviços prestados.',
        ],
        // Destaques extraídos literalmente do texto acima.
        'facts' => [
            ['label' => 'Experiência', 'value' => '5 anos em Finanças'],
            ['label' => 'Formação', 'value' => 'Administração e Ciências Contábeis'],
            ['label' => 'Especializações', 'value' => 'Direito do Trabalho e Direito Imobiliário'],
        ],
    ],

    'testimonials' => [
        [
            'quote' => 'Com a Solution, nossa gestão financeira se tornou muito mais tranquila e eficiente. A equipe é profissional e atenta. Recomendo a Solution, para qualquer empresa que queira otimizar suas finanças.',
            'company' => 'Grupo Conexão Ideal',
            'author' => 'Jorge Eduardo da Silva',
            'role' => 'CEO Grupo Conexão Ideal',
            'logo' => 'assets/images/clientes/conexao-ideal',
        ],
        [
            'quote' => 'A parceria com a Solution BPO Financeira nos trouxe tranquilidade à gestão financeira da Certlider. Recomendamos a equipe eficiente e proativa para qualquer empresa que busque soluções financeiras confiáveis.',
            'company' => 'Certlíder',
            'author' => 'Fábio Jacob',
            'role' => 'Diretor Certlíder',
            'logo' => 'assets/images/clientes/certificado-lider',
        ],
    ],

    // Logotipos de clientes, na ordem do site original.
    'clients' => [
        ['name' => 'Hydrojexe', 'logo' => 'assets/images/clientes/logo-hydrojexe', 'ext' => 'png', 'size' => [148, 87]],
        ['name' => 'Blue Royal Logistic', 'logo' => 'assets/images/clientes/logo-blueroyal', 'ext' => 'png', 'size' => [148, 100]],
        ['name' => 'Grupo Conexão Ideal', 'logo' => 'assets/images/clientes/conexao-ideal', 'ext' => 'jpg', 'size' => [148, 72]],
        ['name' => 'CertLíder Certificado Digital', 'logo' => 'assets/images/clientes/certificado-lider', 'ext' => 'jpg', 'size' => [130, 100]],
    ],

    'faq' => [
        [
            'question' => 'A Solution Business BPO é um sistema?',
            'answer' => '<p>Não, somos mais que isso. Somos uma solução de Terceirização Financeira que combina expertise humana com tecnologia de ponta. Unimos pessoas e inovação para proporcionar economia de tempo e dinheiro para os nossos clientes.</p>',
        ],
        [
            'question' => 'Como a Solution BPO Financeiro pode ajudar minha empresa?',
            'answer' => '<p>A Solution pode melhorar a eficiência financeira, oferecer insights sobre sua saúde financeira e liberar tempo para que você se concentre em outras áreas importantes do seu negócio.</p>',
        ],
        [
            'question' => 'Quais são os benefícios que a Solution BPO Financeiro traz para você?',
            'answer' => '<p>Os principais benefícios incluem:</p><ul><li><strong>Redução de custos:</strong> Economia em folha de pagamento e infraestrutura.</li><li><strong>Acesso a expertise:</strong> Profissionais qualificados cuidam das finanças.</li><li><strong>Eficiência:</strong> Processos financeiros mais ágeis e precisos.</li></ul>',
        ],
    ],

];
