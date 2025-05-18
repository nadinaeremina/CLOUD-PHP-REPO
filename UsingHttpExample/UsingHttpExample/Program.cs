using UsingHttpExample;

// небольшой CLI для работы с конвертером
IRatesProvider provider = new CbrRatesProvider();
CurrencyConverter converter = new CurrencyConverter(provider, TimeSpan.FromDays(1));
while (true)
{
    try
    {
        Console.WriteLine("1. Convert");
        Console.WriteLine("2. Exit");
        Console.Write("Enter choice: ");
        string? reply = Console.ReadLine();
        switch (reply)
        {
            case "1":
                Console.Write("From: ");
                string from = Console.ReadLine() ?? "";
                Console.Write("To: ");
                string to = Console.ReadLine() ?? "";
                Console.Write("Amount: ");
                decimal amount = Convert.ToDecimal(Console.ReadLine());
                decimal result = await converter.Convert(from, to, amount);
                Console.WriteLine($"{amount} {from} = {result} {to}");
                break;
            case "2":
                Environment.Exit(0);
                break;
            default:
                Console.WriteLine("Invalid input");
                break;
        }
    }
    catch (Exception ex)
    {
        Console.WriteLine($"Exception: {ex.Message}");
    }
}