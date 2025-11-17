<section id="newsletter"
  class="container section-container newsletter d-flex flex-column align-items-center justify-content-center"
  role="region"
  aria-labelledby="newsletter-title">

  <header class="section-header d-flex flex-column align-items-center justify-content-center">
    <h2 id="newsletter-title" class="section-title">Newsletter</h2>
    <p class="m-0">
      Receba no seu email as novidades sobre a <strong>Eachline</strong>, acessibilidade e produtos digitais.
    </p>
  </header>

  <?php 
  /**
   * CONFIGURAÇÃO MAILCHIMP — O QUE VOCÊ PRECISA ALTERAR AQUI:
   *
   * 1. Vá no Mailchimp > Audience > Signup forms > Embedded forms.
   * 2. Copie a URL que vem no atributo "action" do <form>.
   *    Exemplo:
   *    https://xxxxxxx.us14.list-manage.com/subscribe/post?u=ABC123&id=DEF456
   *
   * 3. Substitua abaixo em $mailchimp_action
   * 
   * 4. O campo "EMAIL" deve ter name="EMAIL" (é obrigatório no Mailchimp)
   */
  $mailchimp_action = "https://SEU-SUBDOMINIO.usXX.list-manage.com/subscribe/post?u=SEU_U&id=SEU_ID";
  ?>

  <form 
    action="<?php echo esc_url($mailchimp_action); ?>" 
    method="post" 
    class="col-12 col-md-6 newsletter-form"
    target="_blank"
    novalidate
  >
    <div class="row gx-2">

      <label for="emailNewsletter" class="visually-hidden">Email</label>

      <div class="col-7">
        <input 
          class="rounded newsletter-input w-100"
          type="email" 
          id="emailNewsletter" 
          name="EMAIL"  
          placeholder="Insira seu email"
          required
          aria-required="true"
        >
      </div>

      <div class="col-5">
        <button class="button button-secondary rounded w-100 h-100" type="submit">
          Assinar
          <i class="ms-2 fa-solid fa-arrow-right" aria-hidden="true"></i>
        </button>
      </div>

    </div>

    <!-- MAILCHIMP: campo anti-bot (Honeypot) -->
    <!-- 🔥 Copiar exatamente como o Mailchimp fornecer -->
    <div style="position: absolute; left: -5000px;" aria-hidden="true">
      <input type="text" name="b_SEU_U_SEU_ID" tabindex="-1" value="">
    </div>

  </form>

  <p class="newsletter-info mt-2 text-center">
    Ao clicar em "Assinar", você confirma que concorda com nossos 
    <a href="#">Termos e Condições</a>.
  </p>

</section>
