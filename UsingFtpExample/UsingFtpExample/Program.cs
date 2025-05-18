using FluentFTP;

// ПЕРВЫЕ ПРОСТЫЕ ЗАДАЧИ:
// 1. существует файл на локальном компьютере, необходимо выгрузить его на удалённый FTP-сервер
// 2. существует файл на удалённом FTP-сервере, необходимо скачать его на локальный компьютер

using (AsyncFtpClient client = new AsyncFtpClient("ftp://ftpupload.net", "<FTP username>", "<FTP password>"))
{
    // подключиться к ftp-серверу
    Console.WriteLine("connection to ftp server ...");
    await client.Connect();
    Console.WriteLine("connection with ftp server has been established");

    // создадим файл на локальном компьютере
    await File.WriteAllTextAsync("local.txt", $"Hello from local computer, now time is {DateTime.Now}");
    Console.WriteLine("local.txt created (or recreated)");

    // отправим созданный файл на удаленный ftp-сервер используя ftp-клиент
    FtpStatus status = await client.UploadFile("local.txt", "data/uploaded_local.txt");
    Console.WriteLine($"uploaded with status {status}");
}
