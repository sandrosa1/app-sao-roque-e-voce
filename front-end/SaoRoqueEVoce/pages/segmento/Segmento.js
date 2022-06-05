import React, {useState, useEffect, useRef} from 'react';
import {
  StyleSheet,
  Text,
  View,
  Image,
  FlatList,
  TouchableOpacity,
  ActivityIndicator,
  TextInput,
} from 'react-native';
import NavPages from '../../componentes/NavPages';
import CardDetalhes from '../../componentes/CardDetalhes';
import {useIsFocused} from '@react-navigation/native';
import axios from 'axios';

export default function App({route}) {
  const url = 'http://www.racsstudios.com/api/v1';
  const [dados, setDados] = useState([]);
  const [loading, setLoading] = useState(false);
  const [additem, setAdditem] = useState(3);
  const [filtro, setFiltro] = useState(dados);
  const [filtro2, setFiltro2] = useState(filtro);
  const [filtro3, setFiltro3] = useState(filtro2);
  const [organizar, setOrganizar] = useState('desc');
  const [ordenado, setOrdenado] = useState(false);
  const [iconpreco, setIconpreco] = useState(
    require('../../images/menupages/preco.png'),
  );
  const [busca, setBusca] = useState('');
  const [mostrarx, setMostrarx] = useState(false);
  const [mostrarbusca, setMostrarbusca] = useState(false);
  const [mostrarLoading, setMostrarLoading] = useState(false);
  const input = useRef();
  const isFocused = useIsFocused();
  let icon = route.params?.icon;
  let tipo = route.params?.tipo;
  let pesquisa = route.params?.pesquisa;
  let buscaSug = route.params?.busca;

  const [iconestrelas, setIconestrelas] = useState(
    require('../../images/menupages/estrelas.png'),
  );
  const [icondistancia, setIcondistancia] = useState(
    require('../../images/menupages/distancia.png'),
  );
  const [iconmaisprocurados, setIconmaisprocurados] = useState(
    require('../../images/menupages/maisprocurados.png'),
  );
  const [iconfiltro, setIconfiltro] = useState(
    require('../../images/menupages/filtro.png'),
  );

  useEffect(() => {
    loadApi();
  }, []);

  useEffect(() => {
    setFiltro(
      dados.filter(item => {
        if (item.segmento == buscaSug) {
          return true;
        }
      }),
    );
  }, [dados]);

  useEffect(() => {
    setFiltro2(
      filtro.filter(item => {
        if (item.segmento == buscaSug) {
          return true;
        }
      }),
    );
  }, [filtro]);

  useEffect(() => {
    setLoading(true);
    setTimeout(() => {
      setLoading(false);
      setFiltro3(
        filtro2.filter((item, indice) => {
          if (item.segmento == buscaSug && indice < additem) {
            return true;
          }
        }),
      );
    }, 10);
  }, [filtro2, additem]);

  const buscar = () => {
    if (busca == '') {
      setFiltro(dados);
    } else {
      setMostrarbusca(true);
      setFiltro(
        filtro2.filter(item => {
          if (
            item.nomeFantasia.toLowerCase().indexOf(busca.toLowerCase()) > -1 ||
            item.chaves.toLowerCase().indexOf(busca.toLowerCase()) > -1
          ) {
            return true;
          } else {
            return false;
          }
        }),
      );
    }
  };

  const limpaBusca = () => {
    setFiltro(dados);
  };

  async function loadApi() {
    if (loading) return;
    setLoading(true);
    const response = await axios.get(`${url}/allapps`);
    setTimeout(() => setDados(response.data.apps), 300);
    setTimeout(() => {
      setLoading(false);
    }, 500);
  }

  const btnfiltro = tipo => {
    if (organizar == 'asc') {
      setOrganizar('desc');
      {
        tipo == 'preco'
          ? filtroPreco(organizar)
          : tipo == 'avaliacao'
          ? filtroAvaliacao()
          : tipo == 'distancia'
          ? filtroDistancia()
          : tipo == 'maisprocurados'
          ? filtroMaisprocurados()
          : filtroFiltro();
      }
    } else {
      setOrganizar('asc');
      {
        tipo == 'preco'
          ? filtroPreco(organizar)
          : tipo == 'avaliacao'
          ? filtroAvaliacao()
          : tipo == 'distancia'
          ? filtroDistancia()
          : tipo == 'maisprocurados'
          ? filtroMaisprocurados()
          : filtroFiltro();
      }
    }
  };

  const filtroPreco = tipo => {
    if (tipo == 'asc') {
      filtro2.sort((a, b) =>
        a.custoMedio > b.custoMedio ? -1 : b.custoMedio > a.custoMedio ? 1 : 0,
      );
      setOrdenado('Avaliados com Maior custo');
      setIconpreco(require('../../images/menupages/preco0.png'));
      setIconestrelas(require('../../images/menupages/estrelas.png'));
      setIcondistancia(require('../../images/menupages/distancia.png'));
      setIconmaisprocurados(
        require('../../images/menupages/maisprocurados.png'),
      );
      setIconfiltro(require('../../images/menupages/filtro.png'));
    } else {
      filtro2.sort((a, b) =>
        a.custoMedio > b.custoMedio ? 1 : b.custoMedio > a.custoMedio ? -1 : 0,
      );
      setOrdenado('Avaliados com Menor Custo');
      setIconpreco(require('../../images/menupages/preco1.png'));
      setIconestrelas(require('../../images/menupages/estrelas.png'));
      setIcondistancia(require('../../images/menupages/distancia.png'));
      setIconmaisprocurados(
        require('../../images/menupages/maisprocurados.png'),
      );
      setIconfiltro(require('../../images/menupages/filtro.png'));
    }
    setAdditem(3);
    setFiltro(filtro2);
  };
  const filtroAvaliacao = () => {
    filtro2.sort((a, b) =>
      a.estrelas > b.estrelas ? -1 : b.estrelas > a.estrelas ? 1 : 0,
    );
    setOrdenado('Melhores Avaliados');
    setIconpreco(require('../../images/menupages/preco.png'));
    setIconestrelas(require('../../images/menupages/estrelas1.png'));
    setIcondistancia(require('../../images/menupages/distancia.png'));
    setIconmaisprocurados(require('../../images/menupages/maisprocurados.png'));
    setIconfiltro(require('../../images/menupages/filtro.png'));
    setFiltro(filtro2);
    setAdditem(3);
  };
  const filtroDistancia = () => {
    filtro2.sort((a, b) =>
      a.custoMedio > b.custoMedio ? -1 : b.custoMedio > a.custoMedio ? 1 : 0,
    );
    setOrdenado('Mais Próximos de Você');
    setIconpreco(require('../../images/menupages/preco.png'));
    setIconestrelas(require('../../images/menupages/estrelas.png'));
    setIcondistancia(require('../../images/menupages/distancia1.png'));
    setIconmaisprocurados(require('../../images/menupages/maisprocurados.png'));
    setIconfiltro(require('../../images/menupages/filtro.png'));
    setFiltro(filtro2);
    setAdditem(3);
  };
  const filtroMaisprocurados = () => {
    filtro2.sort((a, b) =>
      parseInt(a.visualizacao) > parseInt(b.visualizacao)
        ? -1
        : parseInt(b.visualizacao) > parseInt(a.visualizacao)
        ? 1
        : 0,
    );
    setOrdenado('Mais Procurados');
    setIconpreco(require('../../images/menupages/preco.png'));
    setIconestrelas(require('../../images/menupages/estrelas.png'));
    setIcondistancia(require('../../images/menupages/distancia.png'));
    setIconmaisprocurados(
      require('../../images/menupages/maisprocurados1.png'),
    );
    setIconfiltro(require('../../images/menupages/filtro.png'));
    setFiltro(filtro2);
    setAdditem(3);
  };
  const filtroFiltro = () => {
    setIconfiltro(require('../../images/menupages/filtro0.png'));
    setIconpreco(require('../../images/menupages/preco.png'));
    setIconestrelas(require('../../images/menupages/estrelas.png'));
    setIcondistancia(require('../../images/menupages/distancia.png'));
    setIconmaisprocurados(require('../../images/menupages/maisprocurados.png'));
  };

  return (
    <View style={estilos.container}>
      <View
        style={{
          flex: 1,
          alignItems: 'center',
        }}>
        <FlatList
          data={filtro3}
          keyExtractor={item => String(item.idApp)}
          renderItem={({item}) => <CardDetalhes data={item} />}
          showsVerticalScrollIndicator={false}
          ListHeaderComponent={
            <>
              <View style={{flex: 1}}>
                <NavPages icon={icon} title={tipo} />
                <View
                  style={{
                    paddingHorizontal: 40,
                    flexDirection: 'row',
                    alignItems: 'center',
                  }}>
                  <View style={estilos.containerBusca}>
                    <TextInput
                      ref={input}
                      onSubmitEditing={() => {
                        buscar();
                        setMostrarx(true);
                      }}
                      value={busca}
                      onChangeText={value => {
                        setBusca(value);
                        setMostrarbusca(false);
                      }}
                      placeholder={`O que voce procura em ${pesquisa}?`}
                      placeholderTextColor={'#8E8E8E'}
                      style={estilos.input}></TextInput>
                  </View>
                  <TouchableOpacity
                    onPress={() => {
                      buscar();
                      input.current.blur();
                      if (busca) setMostrarx(true);
                      setMostrarLoading(false);
                      setTimeout(() => {
                        setMostrarLoading(true);
                      }, 1500);
                    }}
                    style={{
                      position: 'absolute',
                      alignSelf: 'center',
                      right: 50,
                      padding: 10,
                    }}>
                    <Image
                      style={estilos.imgLupa}
                      source={require('../../images/buscar.png')}
                    />
                  </TouchableOpacity>
                  {mostrarx && (
                    <TouchableOpacity
                      onPress={() => {
                        setMostrarbusca(false);
                        limpaBusca();
                        setBusca('');
                        input.current.blur();
                        setMostrarx(false);
                      }}
                      style={{
                        position: 'absolute',
                        alignSelf: 'center',
                        left: 40,
                        padding: 10,
                      }}>
                      <Image
                        style={estilos.img2}
                        source={require('../../images/close.png')}
                      />
                    </TouchableOpacity>
                  )}
                </View>
                <View
                  style={{
                    flexDirection: 'row',
                    marginTop: 20,
                    justifyContent: 'space-around',
                  }}>
                  <TouchableOpacity
                    style={estilos.containerIcon}
                    onPress={() => {
                      btnfiltro('preco');
                    }}>
                    <Image style={estilos.img} source={iconpreco} />
                    <Text style={estilos.txt}>Preço</Text>
                  </TouchableOpacity>
                  <TouchableOpacity
                    style={estilos.containerIcon}
                    onPress={() => {
                      btnfiltro('avaliacao');
                    }}>
                    <Image style={estilos.img} source={iconestrelas} />
                    <Text style={estilos.txt}>Avaliação</Text>
                  </TouchableOpacity>
                  <TouchableOpacity
                    style={estilos.containerIcon}
                    onPress={() => {
                      btnfiltro('distancia');
                    }}>
                    <Image style={estilos.img} source={icondistancia} />
                    <Text style={estilos.txt}>Distância</Text>
                  </TouchableOpacity>
                  <TouchableOpacity
                    style={estilos.containerIcon}
                    onPress={() => {
                      btnfiltro('maisprocurados');
                    }}>
                    <Image style={estilos.img} source={iconmaisprocurados} />
                    <Text style={estilos.txt}>{'Mais\nProcurados'}</Text>
                  </TouchableOpacity>
                  <TouchableOpacity
                    style={estilos.containerIcon}
                    onPress={() => {
                      btnfiltro('filtro');
                    }}>
                    <Image style={estilos.img} source={iconfiltro} />
                    <Text style={estilos.txt}>Filtro</Text>
                  </TouchableOpacity>
                </View>
                <Image
                  source={require('../../images/line.png')}
                  style={{
                    alignSelf: 'center',
                    resizeMode: 'contain',
                    marginTop: 10,
                  }}
                />
                <View style={{paddingHorizontal: 30, paddingTop: 10}}>
                  {ordenado ? (
                    <View style={{flexDirection: 'row', height: 25}}>
                      <Text
                        style={[
                          estilos.txt,
                          {textAlign: 'left', fontSize: 15},
                        ]}>
                        Ordenado por{' '}
                      </Text>
                      <Text
                        style={[
                          estilos.txt,
                          {textAlign: 'left', fontSize: 16, fontWeight: 'bold'},
                        ]}>
                        {ordenado}
                      </Text>
                    </View>
                  ) : (
                    <View style={{height: 25}}></View>
                  )}
                  {mostrarbusca && (
                    <View style={{marginBottom: -15}}>
                      <Text style={estilos.h1}>Busca</Text>
                      <View style={{flexDirection: 'row'}}>
                        <Text style={estilos.txt2}>
                          Resultado de busca para{' '}
                        </Text>
                        <Text
                          style={[
                            estilos.txt2,
                            {fontFamily: 'Poppins-Bold', color: '#000'},
                          ]}>
                          {busca?.toUpperCase()}:
                        </Text>
                      </View>
                    </View>
                  )}
                </View>
              </View>
            </>
          }
          ListEmptyComponent={
            <>
              {!mostrarLoading ? (
                <View
                  style={{
                    marginTop: 150,
                    alignItems: 'center',
                    justifyContent: 'center',
                  }}>
                  <ActivityIndicator size={50} color="#910046" />
                </View>
              ) : (
                <View>
                  <View style={{marginHorizontal: 30, marginVertical: 50}}>
                    <View style={{alignItems: 'center'}}>
                      <Image
                        style={{width: 40, height: 40}}
                        source={require('../../images/paginadetalhes/warning-purple.png')}
                      />
                      <Text
                        style={{
                          fontFamily: 'Poppins-Regular',
                          fontSize: 16,
                          color: '#000',
                          textAlign: 'center',
                          marginTop: 5,
                        }}>
                        Não foi encontrado resultados para:
                      </Text>
                      <Text
                        style={{
                          fontFamily: 'Poppins-Bold',
                          fontSize: 16,
                          color: '#000',
                          textAlign: 'center',
                        }}>
                        " {busca} "
                      </Text>
                    </View>
                  </View>
                </View>
              )}
            </>
          }
          onEndReached={() => {
            setAdditem(additem + 1);
          }}
          onEndReachedThreshold={0.15}
          ListFooterComponent={
            <>
              {loading && additem > 3 ? (
                <View
                  style={{
                    marginBottom: 10,
                    alignItems: 'center',
                    justifyContent: 'center',
                  }}>
                  <ActivityIndicator size={35} color="#910046" />
                </View>
              ) : (
                <View style={{marginBottom: 45}}></View>
              )}
            </>
          }
        />
      </View>
    </View>
  );
}

const estilos = StyleSheet.create({
  container: {
    flex: 1,
    justifyContent: 'center',
  },

  menuBar: {
    Flex: 1,
    marginTop: 18,
  },

  h1: {
    marginTop: 5,
    fontSize: 20,
    fontFamily: 'Poppins-SemiBold',
    color: '#910046',
  },
  txt: {
    fontSize: 15,
    fontFamily: 'Poppins-Regular',
    color: '#414141',
  },
  containerIcon: {
    height: 70,
    alignItems: 'center',
  },
  txt: {
    paddingTop: 6,
    fontFamily: 'Roboto-Regular',
    textAlign: 'center',
    fontSize: 12,
    color: '#111',
  },
  txt2: {
    top: -10,
    fontFamily: 'Poppins-Regular',
    fontSize: 14,
    color: '#111',
  },
  img: {
    height: 40,
    width: 40,
    resizeMode: 'contain',
  },
  input: {
    width: '85%',
    height: 48,
    fontSize: 12,
    top: 2,
    paddingLeft: 30,
    borderColor: '#E7E7E7',
    backgroundColor: '#E7E7E7',
    fontFamily: 'Poppins-Regular',
    borderRadius: 8,
    color: '#333',
  },
  containerBusca: {
    width: '100%',
    height: 50,
    borderColor: '#E7E7E7',
    backgroundColor: '#E7E7E7',
    fontFamily: 'Poppins-Regular',
    borderRadius: 8,
  },
  imgLupa: {
    height: 25,
    width: 25,
    resizeMode: 'contain',
  },
  img2: {
    height: 15,
    width: 15,
    resizeMode: 'contain',
  },
});
