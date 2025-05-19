using System.Net;
using System.Net.Mail;
using MailKit.Net.Imap;
using MimeKit;

////////////////////////////////////////////////////////// SMTP ////////////////////////////////////////
// ЗАДАЧА: 
// 1) создать пароль приложения на сервисе mail.ru (https://help.mail.ru/mail/mailer/password/) или ином
// или обеспечить программную аутентификацию любым иным способом любого почтового провайдера
// 2) подставить в программу свои данные и отправить преподавателю письмо на почту nick.ch@mail.ru
// в теме указать Фамилию И., в теле письма указать приветствие всем!
//using (SmtpClient client = new SmtpClient("smtp.mail.ru", 587))
//{
//    client.EnableSsl = true;
//    client.Credentials = new NetworkCredential("<ЯЩИК ОТПРАВКИ>", "<ПАРОЛЬ ПРИЛОЖЕНИЯ>");
//    await client.SendMailAsync("<ЯЩИК ОТПРАВКИ>", "<ПОЛУЧАТЕЛЬ>", "<ТЕМА>", "<ТЕЛО>");
//    Console.WriteLine("The ping mail has been sent");
//}

////////////////////////////////////////////////////////// IMAP ////////////////////////////////////////
// прочитать любые данные из почты
using (ImapClient client = new ImapClient())
{
    // подключиться к серверу email
    await client.ConnectAsync("imap.mail.ru", 993, true);
    Console.WriteLine("connected to imap server");

    // аутентифицироваться на этом сервере
    await client.AuthenticateAsync("nick.email.ru", "dT2ZJpKEnamQ02ih0Hgf");
    // вторым параметром - пароль приложения
    Console.WriteLine("authenticated");

    // работа с почтой аккаунта через IMAP
    // есть возможность искать, перебирать и просматривать письма
    // зайдем в папку "Входящие" и посмотрим темы писем и их отправителей
    await client.Inbox.OpenAsync(MailKit.FolderAccess.ReadOnly);
    Console.WriteLine($"inbox messages count: {client.Inbox.Count} ");

    // посмотрим письма
    for (int i = 0; i < client.Inbox.Count; i++)
    {
        // достаем message по индексу
        MimeMessage emailMessage = await client.Inbox.GetMessageAsync(i);
        Console.WriteLine($"{emailMessage.From} - {emailMessage.Subject}");
    }
}