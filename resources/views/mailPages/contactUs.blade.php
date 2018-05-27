@extends('layouts.mail')


@section('title')
    User contacted us
@endsection


@section('body')
    <tr>
        <td bgcolor="#f4f4f4" align="center" style="padding: 0px 10px 0px 10px;">
            <!--[if (gte mso 9)|(IE)]>
            <table align="center" border="0" cellspacing="0" cellpadding="0" width="600">
                <tr>
                    <td align="center" valign="top" width="600">
            <![endif]-->
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                <!-- COPY -->
                <tr>
                    <td bgcolor="#ffffff" align="left"
                        style="padding: 20px 30px 40px 30px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;">
                        <p style="margin: 0;">This is user send data from <b><mark>{{$email}}</mark></b></p>
                    </td>
                </tr>

                <tr>
                    <td bgcolor="#ffffff" align="left"
                        style="padding: 20px 30px 40px 30px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;">

                        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                            <tr>
                                <td><b>Full name:</b></td>
                                <td>{{$fullName}}</td>
                            </tr>
                            <tr>
                                <td><b>Email:</b></td>
                                <td>{{$email}}</td>
                            </tr>
                            <tr>
                                <td><b>Subject:</b></td>
                                <td>{{$subject}}</td>
                            </tr>
                            <tr>
                                <td><b>Message:</b></td>
                                <td>{{$userMessage}}</td>
                            </tr>

                        </table>

                    </td>
                </tr>

            </table>
            <!--[if (gte mso 9)|(IE)]>
            </td>
            </tr>
            </table>
            <![endif]-->
        </td>
    </tr>
@endsection
