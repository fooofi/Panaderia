@extends('mails.layout')

@section('title', 'Bienvenido')
@section('preheader', 'Bienvenido a MundoTES')


@section('body')
  <tr>
    <td class="content-cell">
      <div class="f-fallback">
        <h1>¡Bienvenido, {{$name}}!</h1>
        <p>Gracias por registrarte en MundoTES.  Estamos encantados de poder apoyarte en este paso tan importante.</p>
        <p>Para que puedas comenzar te invitamos a confirmar tu registro, haciendo click a continuación:</p>
        <!-- Action -->
        <table class="body-action" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation">
          <tr>
            <td align="center">

              <table width="100%" border="0" cellspacing="0" cellpadding="0" role="presentation">
                <tr>
                  <td align="center">
                    <a href="{{$confirm_url}}" class="f-fallback button" target="_blank">Confirmar registro MundoTES</a>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
        <p>Esta es tu información de inicio de sesión:</p>
        <table class="attributes" width="100%" cellpadding="0" cellspacing="0" role="presentation">
          <tr>
            <td class="attributes_content">
              <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                <tr>
                  <td class="attributes_item">
                    <span class="f-fallback">
                      <strong>Nombre de usuario:</strong> {{$username}}
                    </span>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
        <p class="sub-component-text">Recuerda que la Feria MundoTES te entregará las herramientas para poder obtener la información que necesites de las carreras que buscas para tu futuro.</p>
        <h1 class="discount_heading"><strong>¿Cómo funciona?</strong></h1>
        <p>Sigue estos sencillos pasos y ya estarás más cerca de la carrera de tus sueños</p>
        <table class="attributes" width="100%" cellpadding="0" cellspacing="0">
          <tr>
            <td class="attributes_content_nocolor">
              <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                <tr>
                  <td class="attributes_item_logo">
                    <img src="{{ asset("assets/icons/search.png") }}" class="attributes_logo">
                  </td>
                  <td class="attributes_item2">
                    <span class="f-fallback">
                      <p><strong>Busca las carreras de tu interés</strong><br>
                        Puedes hacerlo por nombre de carrera, por tipo de institución y por las categorías que más te interesen.
                      </p>
                    </span>
                  </td>
                </tr>
                <tr>
                  <td class="attributes_item_logo">
                    <img src="{{ asset("assets/icons/contact.png") }}" class="attributes_logo">
                  </td>
                  <td class="attributes_item2">
                    <span class="f-fallback">
                      <p><strong>Contáctate con los Ejecutivos</strong><br>
                        Ejecutivos de las distintas Instituciones te ayudarán a aclarar tus dudas y entregarte información.
                      </p>
                    </span>
                  </td>
                </tr>
                <tr>
                  <td class="attributes_item_logo">
                    <img src="{{ asset("assets/icons/receive.png") }}" class="attributes_logo">
                  </td>
                  <td class="attributes_item2">
                    <span class="f-fallback">
                      <p><strong>Recibe información</strong><br>
                        Por medio de videollamadas, chat, llamado telefónico o información vía e-mail.
                      </p>
                    </span>
                  </td>
                </tr>

              </table>
            </td>
          </tr>
        </table>
        <p>Si tienes alguna duda, envía un e-mail a nuestro <a href="mailto:{{$support_email}}" style="text-decoration: none;">equipo de soporte</a>, responderemos lo más rápido posible.</p>
        <p style="padding-top: 20px">Gracias,
          <br><strong>Equipo MundoTES</strong></p>
        <!-- Sub copy -->
        <table class="body-sub" role="presentation">
          <tr>
            <td>
              <p class="f-fallback sub">Si tienes problemas con el botón, copia y pega la siguiente URL en tu navegador.</p>
              <p class="f-fallback sub">{{$confirm_url}}</p>
              <p class="f-fallback sub">*El enlace tiene una duracion de {{$ttl}} horas.</p>
            </td>
          </tr>
        </table>
      </div>
    </td>
  </tr>
@endsection

