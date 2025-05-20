using Prometheus;

var builder = WebApplication.CreateBuilder(args);
var app = builder.Build();

// ����������� ������ ��������� ��� ��� ����������

app.UseMetricServer();
app.UseHttpMetrics();

app.MapGet("/", () => "Server is running!");
// � ��� �������� ��� ���� ����������:
// http://localhost:8080/metrics

// �������� ��������� ������� ��� �������� ���-�� ��������� � ������� /ping
Counter pingCounter = Metrics.CreateCounter(
    "ping_request_total",
    "Total number of ping requests"
);

app.MapGet("/ping", () =>
{
    pingCounter.Inc(); // ��������� ��������� ������ � ������
    return "pong!";
});

app.Run();

// ����� ��������� ����� ������ - ��� ����� ��������� ����
// ����� ����� ���������� ��������� � �����������