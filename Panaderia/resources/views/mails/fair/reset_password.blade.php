@extends('mails.layout')

@section('title', 'Recuperar Contraseña')
@section('preheader', 'Recupera tu contraseña de MundoTES')


@section('body')
  <tr>
    <td class="content-cell">
      <div class="f-fallback">
        <h1>¡Hola, {{$name}}!</h1>
        <p>Nos dimos cuenta  que solicitaste recuperar tu contraseña para tu cuenta en Feria MundoTES.</p>
        <p>Utiliza el botón a continuación para reestablecerla.  Esta contraseña será válida por las siguientes {{$ttl}} horas.</p>
        <!-- Action -->
        <table class="body-action" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation">
          <tr>
            <td align="center">

              <table width="100%" border="0" cellspacing="0" cellpadding="0" role="presentation">
                <tr>
                  <td align="center">
                    <a href="{{$confirm_url}}" class="f-fallback button" target="_blank">Reestablece tu contraseña</a>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
        <p>Por motivos de seguridad, esta solicitud se generó a través de:</p>
        <table class="attributes" width="100%" cellpadding="0" cellspacing="0" role="presentation">
          <tr>
            <td class="attributes_content">
              <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                <tr>
                  <td class="attributes_item">
                    <span class="f-fallback">
                      <strong>Dispositivo:</strong> {{$so}}
                    </span>
                  </td>
                </tr>
                <tr>
                  <td class="attributes_item">
                    <span class="f-fallback">
                      <strong>Navegador:</strong> {{$browser}}
                    </span>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
        <p class="sub-component-text">Si no solicitaste un reestablecimiento de contraseña, ignora este correo o si tienes alguna duda, envía un e-mail a nuestro <a href="mailto:{{$support_email}}" style="text-decoration: none;">equipo de soporte</a>, responderemos lo más rápido posible.</p>
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

