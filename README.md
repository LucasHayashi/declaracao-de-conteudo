# Gerador de Declaração de conteúdo
## Ferramenta para gerar declaração de conteúdo para correios

A ferramenta permite gerar declarações de conteúdo sem propagandas e com simplicidade.

No desenvolvimento foi utilizado o modelo de input [floating labels](https://getbootstrap.com/docs/5.3/forms/floating-labels) do Bootstrap v5.3, juntamente com o [form validation](https://getbootstrap.com/docs/5.3/forms/validation/) para validar os campos do formulário.

Nos campos CPF/CNPJ, CEP e Data de envio, foi utilizado o [jQuery Mask Plugin](https://getbootstrap.com/docs/5.3/forms/validation) para adicionar máscaras de formatação para esses campos, e validações nos campos CPF/CNPJ para que seja números válidos.

Também foi adicionado o preenchimento automático dos campos cidade, estado e endereço após digitar e tirar o foco do campo CEP.

A ferramenta não salva nenhuma informação enviada, fique à vontade para utilizar e compartilhar com outras pessoas. 
