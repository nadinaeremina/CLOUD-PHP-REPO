var builder = WebApplication.CreateBuilder(args);
var app = builder.Build();

app.MapGet("/", (HttpContext context) =>
{
    string part = $"{context.Request.Scheme}://{context.Request.Host}";
    return new Dictionary<string, string>()
    {
        { "/", part },
        { "/ping", $"{part}/ping" },
        { "/info", $"{part}/info" }
    };
});

app.MapGet("/ping", () => new { Message = "pong" });
app.MapGet("/info", () => new {
    Environment.MachineName,
    Environment.OSVersion,
    Environment.CurrentDirectory
});

app.Run();

// нужно сгенерировать dockerfile - кликаем правой кнопкой по проекту - добавить - поддержка docker
// установить для запуска http обратно вместо dockerfile
// через IDE можно запускать Container(Docker) - запустить через Visual Code