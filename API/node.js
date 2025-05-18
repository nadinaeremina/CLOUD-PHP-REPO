import * as PlayHT from 'playht';
import fs from 'fs';

// Initialize client
PlayHT.init({
  userId: 'J6RK898JGFTDTEVBuwnvMxABKNn2',
  apiKey: '8a9187a6afe74168b8c14b57a1412045',
});

async function streamAudio(text) {
  const stream = await PlayHT.stream('All human wisdom is summed up in these two words: Wait and hope.', { voiceEngine: 'PlayDialog' });
  stream.on('data', (chunk) => {
    // Do whatever you want with the stream, you could save it to a file, stream it in realtime to the browser or app, or to a telephony system
    fs.appendFileSync('output.mp3', chunk);
  });
  return stream;
}

const url = 'https://api.play.ht/api/v2/voices';
const options = {
  method: 'GET',
  headers: {
    accept: 'application/json',
    AUTHORIZATION: '867a14e0321b4de89cc497cc35ae2eb3',
    'X-USER-ID': 'J6RK898JGFTDTEVBuwnvMxABKNn2'
  }
};

fetch(url, options)
  .then(res => res.json())
  .then(json => console.log(json))
  .catch(err => console.error(err));