using Prometheus;

var builder = WebApplication.CreateBuilder(args);
var app = builder.Build();

// подключение метрик прометеус для асп приложения

app.UseMetricServer();
app.UseHttpMetrics();

app.MapGet("/", () => "Server is running!");
// у нас появится еще один обработчик:
// http://localhost:8080/metrics

// создадим кастомный счетчик для подсчета кол-ва обращений к ресурсу /ping
Counter pingCounter = Metrics.CreateCounter(
    "ping_request_total",
    "Total number of ping requests"
);

app.MapGet("/ping", () =>
{
    pingCounter.Inc(); // посчитать очередной запрос в метрик
    return "pong!";
});

app.Run();

// нужно поставить пакет метрик - для этого подрубаем либы
// затем нужно приложение подружить с прометеусом