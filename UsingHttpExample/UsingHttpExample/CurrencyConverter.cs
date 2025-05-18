using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace UsingHttpExample
{
    // CurrencyConverter - класс конвертера валют по принципу из всех во все
    internal class CurrencyConverter
    {
        private readonly IRatesProvider _provider;
        // когда последний раз обновляли крс валют
        private DateTime lastUpdateTime;
        private TimeSpan updatePeriod;
        
        // rates - курсы валют по отношению к базовой валюте
        // ключ - код валюты, значение - коэффициент отношения данной валюты к базовой
        // базовой можно считать валюту с коэффициентом 1
        private Dictionary<string, decimal> rates = new();

        public CurrencyConverter(IRatesProvider provider, TimeSpan updatePeriod)
        {
            _provider = provider;
            this.updatePeriod = updatePeriod;
            lastUpdateTime = DateTime.MinValue;
        }

        public async Task<decimal> Convert(string from, string to, decimal value)
        {
            // обновить валюты если это необходимо
            if (lastUpdateTime == DateTime.MinValue || DateTime.UtcNow - lastUpdateTime > updatePeriod)
            {
                // обновление курса валют
                rates = await _provider.GetRates();
                lastUpdateTime = DateTime.UtcNow;
                Console.WriteLine("rates have been updated");
            }

            // выполнить конвертацию и вернуть результат
            if (!rates.ContainsKey(from) || !rates.ContainsKey(to))
            {
                throw new ArgumentException("unsupported currency");
            }
            return value / rates[from] * rates[to];
        }
    }
}
