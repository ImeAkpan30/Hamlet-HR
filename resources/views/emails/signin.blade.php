<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mail Notification</title>

<style>
    header,footer
    {
      padding: 20px !important;
      background: lightgray !important;
      color: grey !important;
      text-align:center !important;
      margin-top: 8px !important;
      border-radius: 5px !important;
    }

    *
    {
        text-align: center !important;

    }
    main,section
    {
        color: rgb(56, 54, 54) !important;
    }
    img{
        border-radius:50px !important;
    }
</style>

</head>
<body>

    <header>
          <h1>Hamlet</h1>
    </header>

    <main>

           <p><strong><h3>Hi {{$data['username']}} You just Signin to HAMLET(HRSM).</h3></strong><br>
             Enjoy the latest and lagest Human Resource Management System Software in Nigeria. <br>
             Create and manage more than 1million employees, payroll system and attandance for your company
           </p>
            <p>
                Your session is running!!!
            </p>
    </main>

    <hr>
    <section>
          Visit back  <a href="https://app.hamlethr.netlify.com">https://app.hamlethr.netlify.com</a>
    </section>

    <footer>
        © 2020 Hamlet. All right reserved.
    </footer>

</body>
</html>
