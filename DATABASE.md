# Estrutura do Banco de Dados

Banco de Dados: `giusoft`

```sql
CREATE DATABASE giusoft;
USE giusoft;
```
## Tabela

### Products

Criação da tabela `products`:

```sql
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```
Inserindo dados na tabela `products`:

```sql
INSERT INTO products (name, description, price) VALUES
    ('Celular', 'Celular de última geração com ótima câmera', 1599.99),
    ('Cadeira', 'Cadeira ergonômica ideal para escritório', 349.90),
    ('Relógio', 'Relógio esportivo com monitor de frequência', 199.99),
    ('Notebook', 'Notebook ultrafino com tela de 15 polegadas', 3499.99),
    ('Fone de Ouvido', 'Fone de ouvido com cancelamento de ruído', 299.99),
    ('Smart TV', 'Smart TV 4K de 55 polegadas com Wi-Fi', 2499.99),
    ('Geladeira', 'Geladeira frost free com capacidade de 400L', 2999.90),
    ('Mouse', 'Mouse sem fio com alta precisão e velocidade', 89.90),
    ('Teclado', 'Teclado mecânico RGB para jogos', 199.90),
    ('Bicicleta', 'Bicicleta mountain bike aro 29', 1299.00),
    ('Tablet', 'Tablet 10 polegadas com 128GB de armazenamento', 1299.99),
    ('Impressora', 'Impressora multifuncional a laser', 749.90),
    ('Ventilador', 'Ventilador de mesa com 3 velocidades', 129.90),
    ('Cafeteira', 'Cafeteira elétrica com capacidade para 12 xícaras', 199.90),
    ('Câmera Fotográfica', 'Câmera digital com zoom de 30x', 2599.99),
    ('Headset', 'Headset gamer com microfone de alta qualidade', 349.90),
    ('Fogão', 'Fogão 4 bocas com acendimento automático', 1199.90),
    ('Micro-ondas', 'Micro-ondas 20L com painel digital', 599.90),
    ('Chuveiro', 'Chuveiro elétrico com regulagem de temperatura', 99.90),
    ('Smartphone', 'Smartphone com 128GB de memória interna', 2399.99),
    ('Sofá', 'Sofá 3 lugares em tecido resistente', 1999.00),
    ('Guarda-Roupa', 'Guarda-roupa 6 portas com espelho', 1299.90),
    ('Aspirador de Pó', 'Aspirador de pó portátil com filtro HEPA', 499.90),
    ('Liquidificador', 'Liquidificador 2 velocidades com copo de 1.5L', 149.90),
    ('Torradeira', 'Torradeira com capacidade para 2 fatias', 99.90),
    ('Smartwatch', 'Smartwatch com monitor cardíaco e GPS', 899.99),
    ('Ar Condicionado', 'Ar condicionado split 12.000 BTUs', 2499.00),
    ('Lava-Louças', 'Lava-louças 12 serviços com 6 programas', 1999.00),
    ('Cama Box', 'Cama box casal com molas ensacadas', 1499.90),
    ('Abajur', 'Abajur moderno de mesa com design minimalista', 119.90),
    ('Forno Elétrico', 'Forno elétrico de bancada 45L', 699.90),
    ('Smart Speaker', 'Smart speaker com assistente virtual integrada', 399.99),
    ('Drone', 'Drone com câmera HD e controle remoto', 1599.90),
    ('Playstation 5', 'Console de videogame Playstation 5', 4999.99),
    ('Xbox Series X', 'Console de videogame Xbox Series X', 4499.99),
    ('Kindle', 'Leitor de e-books com tela antirreflexo', 499.99),
    ('Cadeira Gamer', 'Cadeira gamer com apoio para os braços ajustável', 899.99),
    ('Monitor', 'Monitor LED de 24 polegadas Full HD', 899.99),
    ('Projetor', 'Projetor portátil com resolução HD', 1299.99),
    ('Caixa de Som Bluetooth', 'Caixa de som Bluetooth portátil', 299.99),
    ('Churrasqueira Elétrica', 'Churrasqueira elétrica compacta', 349.90),
    ('Máquina de Lavar', 'Máquina de lavar 11kg com painel digital', 2199.99),
    ('Secadora', 'Secadora de roupas 10kg com múltiplos ciclos', 1999.00),
    ('Purificador de Água', 'Purificador de água com filtro de carvão', 499.90),
    ('Fogão Cooktop', 'Fogão cooktop de 5 bocas em vidro temperado', 899.99),
    ('Grill Elétrico', 'Grill elétrico antiaderente com controle de temperatura', 249.90),
    ('Notebook Gamer', 'Notebook gamer com placa de vídeo dedicada', 5999.00),
    ('Câmera de Segurança', 'Câmera de segurança com visão noturna', 399.90),
    ('Aquecedor Elétrico', 'Aquecedor elétrico portátil com 3 níveis de aquecimento', 299.90);
```
---
