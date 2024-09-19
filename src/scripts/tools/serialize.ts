export function serialize<Output>(formData: FormData): Output {
  const output: Partial<Output> = {};

  formData.forEach((value, key) => {
    output[key] = value;
  });

  return output as Output;
}