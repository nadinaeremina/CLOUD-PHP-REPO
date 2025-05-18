using System;
using System.Collections.Generic;
using System.Linq;
using System.Net.Http.Json;
using System.Text;
using System.Threading.Tasks;

namespace UsingHttpExample
{
    internal class CbrRatesProvider : IRatesProvider
    {
        private const string API_URL = "https://www.cbr-xml-daily.ru/latest.js";
        // наш клиент, через который можно делать запросы
        private readonly HttpClient _client;

        public CbrRatesProvider()
        {
            _client = new HttpClient();
        }

        // тип для чтения ответа
        private record RatesData(Dictionary<string, decimal> Rates);

        public async Task<Dictionary<string, decimal>> GetRates()
        {
            // 1. сделать запрос к ресурсу и получить ответ
            HttpResponseMessage response = await _client.GetAsync(API_URL);

            // 2. десериализовать тело ответа
            RatesData data = await response.Content.ReadFromJsonAsync<RatesData>() ?? new RatesData(Rates: new());
            data.Rates.Add("RUB", 1);
            return data.Rates;
        }
    }
}
