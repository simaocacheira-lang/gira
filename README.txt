================================================================================
NOME DO PROJETO: Gira - Sistema Web de Apoio ao Inventário Hospitalar
ESTUDANTE: Simão António Andrade Cacheira
NÚMERO: 1241251
UNIDADE CURRICULAR: Sistemas de Informação e Base de Dados Aplicados à Saúde
ANO LETIVO: 2025/2026
================================================================================

1. INSTRUÇÕES PARA INSTALAÇÃO E EXECUÇÃO
--------------------------------------------------------------------------------
1. Extrair o conteúdo do ficheiro ZIP.
2. Colocar a diretoria do projeto no servidor web local (ex: XAMPP/htdocs). A estrutura de pastas deverá garantir que o caminho de execução corresponde a:
   http://127.0.0.1/sibdas/1241251/gira/
3. Aceder ao sistema de gestão de base de dados (ex: phpMyAdmin) e importar o ficheiro "Base de Dados Gira.sql" fornecido em anexo. Este ficheiro irá recriar a estrutura completa (tabelas, relações) e popular o sistema com dados de teste realistas.
4. O ficheiro de conexão à base de dados encontra-se em `/private/db.php`. Por defeito, está configurado para o servidor do ISEP (vsgate-s1.dei.isep.ipp.pt:10464).
5. Para iniciar a aplicação, aceder no browser a:
   http://127.0.0.1/sibdas/1241251/gira/public/index.php


2. INSTRUÇÕES PARA REALIZAÇÃO DOS PRINCIPAIS TESTES
--------------------------------------------------------------------------------
Para avaliar a totalidade das funcionalidades do sistema, sugere-se a seguinte sequência de testes:

A. Front Office (Área Pública)
   - Navegar na página inicial e verificar a responsividade e o carrossel contínuo de funcionalidades.

B. Back Office (Área Privada) - Efetuar o Login com o perfil de Administrador
   - Dashboard: Verificar o cálculo automático das métricas (Equipamentos Operacionais, Taxa de Disponibilidade e O.T.s pendentes).
   - Equipamentos (CRUD): Testar o registo de um novo equipamento. Testar a pesquisa avançada dinâmica (DataTables).
   - Armazém e Ruturas: Aceder ao módulo de armazém e verificar os alertas visuais para artigos cujo stock atual é inferior ao stock mínimo definido.
   - Manutenção (O.T.s): Aceder à manutenção e verificar o calendário dinâmico (FullCalendar) com as datas de "Próxima Revisão" dos equipamentos. Fechar uma O.T. pendente.
   - Documentos: Efetuar o upload de um ficheiro PDF associado a um equipamento. Em seguida, testar o abate desse documento.
   - Backoffice Público (CMS): Alterar os textos institucionais ou a morada. Voltar à página /public/index.php e confirmar que os dados foram atualizados com sucesso.
   - Testes de Defesa (Integridade): Tentar eliminar uma "Localização" que possua equipamentos associados, ou tentar apagar um "Fornecedor" com contratos ativos. O sistema deverá bloquear a ação e exibir um erro.


3. CREDENCIAIS DE ACESSO (PERFIS DO SISTEMA)
--------------------------------------------------------------------------------
Para testar os diferentes níveis de acesso e restrições de segurança da plataforma, utilize as seguintes credenciais:

PERFIL: Administrador (Acesso total ao sistema, configuração de utilizadores e logs)
- E-mail: admin@teste.pt
- Password: 123456

PERFIL: Engenheiro/Técnico (Acesso operacional a O.T.s, Equipamentos e Armazém)
- E-mail: engenheiro@teste.pt
- Password: 123456

PERFIL: Médico/Enfermeiro (Apenas leitura do parque e permissão para abrir avarias)
- E-mail: medico@teste.pt
- Password: 123456

4. INFORMAÇÃO ADICIONAL E FUNCIONALIDADES DE VALORIZAÇÃO
--------------------------------------------------------------------------------
Este projeto ultrapassou os requisitos mínimos exigidos pelo guião da unidade curricular, implementando um conjunto de funcionalidades avançadas para simular um ambiente CMMS clínico real:

- Exportação de Relatórios: Geração de relatórios de inventário e O.T.s em formato CSV compatível com Microsoft Excel (incluindo tratamento de BOM para leitura de acentos no Windows).
- Motor de Auditoria e Soft Deletes: A instrução DELETE foi substituída pelo preenchimento do campo "apagado_em" (Abate Lógico). Todas as ações transacionais ficam guardadas num histórico de Auditoria de Acessos (Logs), com capacidade de restauro.
- Transações Seguras (ACID): Operações complexas dependentes (como fechar O.T.s ou atualizar CMS) utilizam blocos de transação PDO (beginTransaction e commit/rollBack) para prevenir corrupção da base de dados.
- Módulo de Armazém Logístico: Arquitetura de base de dados expandida com relação N:M para controlo de peças e consumíveis clínicos associados a cada equipamento.
- Interface Dark Mode: Adaptação visual ao utilizador final programada para persistir na sessão através de LocalStorage.

O histórico completo e detalhado do desenvolvimento (Frontend e Backend) encontra-se no ficheiro "commits.txt" na raiz deste projeto.